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
 * Class WebsiteHasUserQuery
 * @package choate\coderelease\models\querys
 * @author Choate <choate.yao@gmail.com>
 */
class WebsiteHasUserQuery extends ActiveQuery
{
    /**
     * @param $website
     * @param $user
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return bool
     */
    public function can($website, $user) {
        return $this->where(['website_id' => $website, 'user_id' => $user])->exists();
    }
}