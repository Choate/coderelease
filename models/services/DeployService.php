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
use choate\coderelease\models\entities\Websites;
use choate\coderelease\models\forms\DeployForm;
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
                $this->execDeploy($form, $event->sender);
                $event->sender->deploy_version = $this->execCurrentVersion($event->sender);
                $event->sender->update();
            }
            );
            $model->setAttributes($form->getAttributes(null, ['tasks_id']));
            $model->insert(false, array_keys($model->getAttributes(null, ['deploy_version'])));
        }

        return $form;
    }

    public function rollback(Deploy $model) {
        DepControl::run(['deployScript' => $model->website->deploy_script, 'deployProject' => $model->website->website->deploy_project])->rollback($model->version);
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
        $result = DepControl::run(['deployScript' => $website->deploy_script, 'deployProject' => $website->deploy_project])->current();
        list(,$version,) = explode("\n", $result);

        return $version;
    }
}
