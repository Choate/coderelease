<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\components;

/**
 * Class ActiveRecord
 * @package choate\coderelease\components
 * @author Choate <choate.yao@gmail.com>
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    public function getIdentityClass() {
        return \Yii::$app->user->identityClass;
    }

    public static function batchInsertByCondition(array $columns, array $rows, array $condition) {
        array_walk($rows, function(&$value, $key) use ($condition) {
            $value = array_merge((array)$value, array_values($condition));
        });

        return static::getDb()->createCommand()->batchInsert(static::tableName(), array_merge($columns, array_keys($condition)), $rows)->execute();
    }


}