<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\querys;

use choate\coderelease\components\ActiveQuery;

/**
 * Class DeployQuery
 * @package choate\coderelease\models\querys
 * @author Choate <choate.yao@gmail.com>
 */
class DeployQuery extends ActiveQuery
{
    /**
     * @param       $id
     * @param array $options
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return \yii\data\ActiveDataProvider
     */
    public function getItemByWebsite($id, array $options = []) {
        return $this->where(['id' => $id])->provider($options);
    }
}