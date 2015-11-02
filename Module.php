<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease;

use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package choate\coderelease
 * @author Choate <choate.yao@gmail.com>
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $layout = 'main';
    public $defaultRoute = 'websites/index';

    /**
     * @inheritDoc
     */
    public function bootstrap($app) {
        \Yii::setAlias('@choate/coderelease', __DIR__);
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap[$this->id] = [
                'class' => '\choate\coderelease\console\CodeReleaseController',
            ];
        }
    }


}