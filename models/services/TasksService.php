<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\services;

use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\forms\TasksForm;
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
}
