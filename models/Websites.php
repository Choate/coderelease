<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models;

use yii\db\ActiveRecord;

/**
 * Class Websites
 * @property int $id
 * @property string $name
 * @property string $website
 * @property int    $status
 * @package choate\coderelease\models
 * @author Choate <choate.yao@gmail.com>
 */
class Websites extends ActiveRecord
{
    public static function tableName() {
        return '{{%websites}}';
    }

}