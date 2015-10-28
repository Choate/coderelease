<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models;

use choate\coderelease\components\ActiveRecord;

/**
 * Class Tasks
 * @property int    $id
 * @property string $title
 * @property string $hash
 * @property int    $apply_time
 * @property int    $applicant
 * @property int    $auditor
 * @property int    $audi_time
 * @property int    $websites_id
 * @property int    $status
 * @package choate\coderelease\models
 * @author Choate <choate.yao@gmail.com>
 */
class Tasks extends ActiveRecord
{
    public static function tableName() {
        return '{{%tasks}}';
    }

    public function getUserByAuditor() {
        return $this->hasOne($this->getIdentityClass(), ['id' => 'auditor']);
    }

    public function getUserByApplicant() {
        return $this->hasOne($this->getIdentityClass(), ['id' => 'applicant']);
    }
}