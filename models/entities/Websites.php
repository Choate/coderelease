<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\entities;

use choate\coderelease\models\querys\WebsitesQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Websites
 * @property int    $id
 * @property string $name
 * @property string $website
 * @property int    $status
 * @property string $deploy_script
 * @package choate\coderelease\models
 * @author Choate <choate.yao@gmail.com>
 */
class Websites extends ActiveRecord
{
    const STATUS_IDLE = 0;
    const STATUS_BUSY = 1;

    public static function tableName() {
        return '{{%websites}}';
    }

    /**
     * @inheritDoc
     * @return WebsitesQuery
     */
    public static function find() {
        return \Yii::createObject(WebsitesQuery::className(), [get_called_class()]);
    }

    public function getStatusItem() {
        return [self::STATUS_BUSY => '繁忙', self::STATUS_IDLE => '闲置'];
    }

    public function getStatusName() {
        return ArrayHelper::getValue($this->getStatusItem(), $this->status);
    }

    public function getIsBusy() {
        return $this->status === self::STATUS_BUSY;
    }

    public function getIsIdle() {
        return $this->status === self::STATUS_IDLE;
    }
}