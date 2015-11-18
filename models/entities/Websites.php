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
 * @property string $deploy_script
 * @property string $deploy_project
 * @package choate\coderelease\models
 * @author Choate <choate.yao@gmail.com>
 */
class Websites extends ActiveRecord
{

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

    public function getWebsiteHasUser() {
        return $this->hasMany(WebsiteHasUser::className(), ['website_id' => 'id']);
    }

    public function getUserItem() {
        return $this->hasMany(\Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
}