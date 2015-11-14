<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\services;

use choate\coderelease\models\entities\WebsiteHasUser;
use yii\base\Object;
use yii\web\ForbiddenHttpException;

/**
 * Class WebsiteService
 * @package choate\coderelease\models\services
 * @author Choate <choate.yao@gmail.com>
 */
class WebsiteService extends Object
{
    /**
     * @param $website
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return bool
     * @throws ForbiddenHttpException
     */
    public static function checkAccess($website) {
        if (!\Yii::$app->user->id || !WebsiteHasUser::find()->can($website, \Yii::$app->user->id)) {
            throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        return true;
    }
}