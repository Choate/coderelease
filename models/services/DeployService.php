<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\services;

use choate\coderelease\helpers\DepControl;
use choate\coderelease\models\entities\Deploy;
use choate\coderelease\models\entities\DeployHasTasks;
use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\forms\DeployForm;
use yii\base\Event;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class DeployService
 * @package choate\coderelease\models\services
 * @author Choate <choate.yao@gmail.com>
 */
class DeployService extends Object
{
    public function deploy($id, $data) {
        $form              = new DeployForm();
        $form->websites_id = $id;
        if ($form->load($data, '') && $form->validate()) {
            $model = new Deploy(['scenario' => Deploy::SCENARIO_TRANSACTION]);
            $model->on(Deploy::EVENT_AFTER_INSERT, function ($event) use ($form) {
                $website = $event->sender->website;
                $this->execDeploy($form, $event->sender);
                $event->sender->deploy_version = DepControl::run(['deployScript' => $website->deploy_script, 'deployProject' => $website->deploy_project])->current();
                $event->sender->update();
                DeployHasTasks::batchInsertByCondition(['tasks_id'], (array)$form->tasks_id, ['deploy_id' => $event->sender->id]);
                Tasks::updateAll(['status' => Tasks::STATUS_SUCCESS], ['id' => $form->tasks_id]);
            }
            );
            $model->setAttributes($form->getAttributes(null, ['tasks_id']));
            $model->insert(false, array_keys($model->getAttributes(null, ['deploy_version'])));
        }

        return $form;
    }

    public function rollback(Deploy $model) {
        $deploy         = clone $model;
        $deploy->status = Deploy::ROLLBACK_SUCCESS;
        $deploy->setScenario(Deploy::SCENARIO_TRANSACTION);
        $deploy->on(Deploy::EVENT_BEFORE_UPDATE, function ($event) {
            $model = $event->sender;
            Tasks::updateAll(['status' => Tasks::STATUS_ROLLBACK], ['id' => ArrayHelper::getColumn($model->deployHasTask, 'tasks_id')]);
            DepControl::run(['deployScript' => $model->website->deploy_script, 'deployProject' => $model->website->website->deploy_project])->rollback($model->deploy_version);
        }
        );
        $result        = $deploy->update();
        $model->status = $deploy->status;

        return $result;
    }

    public function redeploy(Deploy $model, $data) {
        Event::on(Deploy::className(), Deploy::EVENT_AFTER_INSERT, function ($event) use ($model) {
            $model->status = Deploy::REDEPLOY_SUCCESS;
            $model->update(false);
        }
        );
        Event::on(DeployForm::className(), DeployForm::EVENT_AFTER_VALIDATE, function ($event) use ($model) {
            $event->sender->tasks_id = array_unique(array_merge($event->sender->tasks_id, ArrayHelper::getColumn($model->deployHasTask, 'tasks_id', [])));
        }
        );

        return $this->deploy($model->websites_id, $data);
    }

    private function execDeploy($form, $model) {
        $models      = Tasks::find()->byId($form->tasks_id)->all();
        $hashItem    = ArrayHelper::getColumn($models, 'hash');
        $messageItem = ArrayHelper::getColumn($models, 'title');
        $website     = $model->website;
        DepControl::run(['deployScript' => $website->deploy_script, 'deployProject' => $website->deploy_project])->deploy(implode(';', $hashItem), implode(';', $messageItem));
    }

    private function execCurrentVersion($model) {
        $website = $model->website;

        return DepControl::run(['deployScript' => $website->deploy_script, 'deployProject' => $website->deploy_project])->current();
    }
}
