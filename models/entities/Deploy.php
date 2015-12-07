<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\entities;

use choate\coderelease\components\ActiveRecord;
use choate\coderelease\models\querys\DeployQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Deploy
 * @package choate\coderelease\models\entities
 * @author Choate <choate.yao@gmail.com>
 */
class Deploy extends ActiveRecord
{
    const DEPLOY_SUCCESS = 0;
    const ROLLBACK_SUCCESS = 1;
    const REDEPLOY_SUCCESS = 2;

    const SCENARIO_TRANSACTION = 'transaction';

    /**
     * @inheritDoc
     */
    public static function tableName() {
        return '{{%deploy_record}}';
    }

    /**
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return DeployQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find() {
        return \Yii::createObject(DeployQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritDoc
     */
    public function transactions() {
        return [
            self::SCENARIO_TRANSACTION => self::OP_ALL
        ];
    }

    /**
     * @inheritDoc
     */
    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => $this->attributes(),
            self::SCENARIO_TRANSACTION => $this->attributes()
        ];
    }

    public function getStatusName() {
        return ArrayHelper::getValue($this->getStatusItem(), $this->status);
    }

    public function getStatusItem() {
        return [self::DEPLOY_SUCCESS => '部署成功', self::ROLLBACK_SUCCESS => '回滚成功', self::REDEPLOY_SUCCESS => '重新部署成功'];
    }

    public function getIsDeploy() {
        return $this->status == self::DEPLOY_SUCCESS;
    }

    public function getIsRollback() {
        return $this->status == self::ROLLBACK_SUCCESS;
    }

    public function getWebsite() {
        return $this->hasOne(Websites::className(), ['id' => 'websites_id']);
    }

    public function getDeployHasTask() {
        return $this->hasMany(DeployHasTasks::className(), ['deploy_id' => 'id']);
    }

    public function getTaskItem() {
        return $this->hasMany(Tasks::className(), ['id' => 'tasks_id'])->via('deployHasTask');
    }
}