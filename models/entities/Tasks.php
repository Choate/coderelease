<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\entities;

use choate\coderelease\components\ActiveRecord;
use choate\coderelease\models\querys\TasksQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Tasks
 * @property int      $id
 * @property string   $title
 * @property string   $hash
 * @property int      $apply_time
 * @property int      $applicant
 * @property int      $auditor
 * @property int      $audit_time
 * @property int      $websites_id
 * @property int      $status
 * @property Websites $website
 * @package choate\coderelease\models
 * @author Choate <choate.yao@gmail.com>
 */
class Tasks extends ActiveRecord
{

    const STATUS_APPLY = 0;
    const STATUS_PASS = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ROLLBACK = 3;
    const SCENARIO_TRANSACTION = 'transaction';

    public static function tableName() {
        return '{{%tasks}}';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => $this->attributes(),
            self::SCENARIO_TRANSACTION => $this->attributes()
        ];
    }

    /**
     * @inheritDoc
     */
    public function transactions() {
        return [
            self::SCENARIO_TRANSACTION => self::OP_ALL,
        ];
    }


    /**
     * @inheritdoc
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return TasksQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find() {
        return \Yii::createObject(TasksQuery::className(), [get_called_class()]);
    }

    public function getAuditor() {
        return $this->hasOne($this->getIdentityClass(), ['id' => 'auditor']);
    }

    public function getApplicant() {
        return $this->hasOne($this->getIdentityClass(), ['id' => 'applicant']);
    }

    public function getWebsite() {
        return $this->hasOne(Websites::className(), ['id' => 'websites_id']);
    }

    public function getStatusItem() {
        return [self::STATUS_APPLY => '待审核', self::STATUS_PASS => '审核通过', self::STATUS_SUCCESS => '上线成功', self::STATUS_ROLLBACK => '回滚成功'];
    }

    public function getStatusName() {
        return ArrayHelper::getValue($this->getStatusItem(), $this->status);
    }

    public function getIsPublish() {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function getIsPass() {
        return $this->status === self::STATUS_PASS;
    }

    public function getIsRollback() {
        return $this->status === self::STATUS_ROLLBACK;
    }

    public function getIsApply() {
        return $this->status === self::STATUS_APPLY;
    }
}