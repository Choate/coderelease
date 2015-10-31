<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\services;

use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\entities\Websites;
use choate\coderelease\models\forms\TasksForm;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use yii\base\Object;

/**
 * Class TasksService
 * @package choate\coderelease\models\services
 * @author Choate <choate.yao@gmail.com>
 */
class TasksService extends Object
{
    /**
     * @param $id
     * @param $data
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return TasksForm
     * @throws \Exception
     */
    public function apply($id, $data) {
        $form = new TasksForm(['scenario' => 'apply']);
        $form->setAttributes(['websites_id' => $id]);
        if ($form->load($data, '') && $form->validate()) {
            $model = new Tasks();
            $model->setAttributes($form->getAttributes(), false);
            $model->on(Tasks::EVENT_AFTER_INSERT, function($event) {
                /* @var Tasks $model */
                $model = $event->sender;
                $model->website->status = Websites::STATUS_BUSY;
                $model->website->update(false);
            });
            $model->insert(false, $form->activeAttributes());
        }

        return $form;
    }

    /**
     * @param Tasks $model
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return bool|int
     * @throws \Exception
     */
    public function audit(Tasks $model) {
        if (!$model->getIsApply()) {
            $model->addError('status', '该任务已经审核');

            return false;
        }
        $model->status = Tasks::STATUS_PASS;
        $model->auditor = (int)\Yii::$app->user->id;
        $model->audit_time = time();

        return $model->update(false);
    }

    public function publish(Tasks $model) {
        if (!$model->getIsPass()) {
            $model->addError('status', '该任务已经发布');

            return false;
        }
        $model->setScenario($model::SCENARIO_TRANSACTION);
        $model->status = Tasks::STATUS_SUCCESS;
        $model->on(Tasks::EVENT_BEFORE_UPDATE, function($event) {
            /* @var Tasks $model */
            $model = $event->sender;
            $exce = $this->runCommand('whereis dep');
            $exce = trim(substr($exce, strpos($exce, '/')));
            $command = sprintf('php %s --file=%s --hash=%s deploy %s', $exce, $model->website->deploy_script, $model->hash, $model->website->deploy_project);
            $this->runCommand($command);
        });
        $model->on(Tasks::EVENT_AFTER_UPDATE, function($event) {
            /* @var Tasks $model */
            $model = $event->sender;
            $model->website->status = Websites::STATUS_IDLE;
            $model->website->update(false);
        });

        return $model->update(false);
    }

    public function rollback(Tasks $model) {
        if (!$model->getIsPublish()) {
            $model->addError('status', '该任务已经回滚');

            return false;
        }
        $model->on(Tasks::EVENT_BEFORE_UPDATE, function($event) {
            /* @var Tasks $model */
            $model = $event->sender;
            $command = sprintf('php dep --file=%s --hash=%s rollback %s', $model->website->deploy_script, $model->hash, $model->website->deploy_project);
            $this->runCommand($command);
        });
        $model->status = Tasks::STATUS_ROLLBACK;

        return $model->update(false);
    }

    /**
     * @param $command
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return bool
     */
    protected function runCommand($command) {
        $process = new Process($command);
        $process->setTimeout(120);
        $process->mustRun();

        return $process->getOutput();
    }
}
