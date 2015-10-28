<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
error_reporting(-1);
define('YII_DEBUG', true);
define('YII_ENV', 'test');
define('YII_ENV_TEST', true);
define('YII_ENABLE_ERROR_HANDLER', false);
$_SERVER['SCRIPT_NAME']     = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
require_once(__DIR__ . '/../../../../vendor/autoload.php');
require_once(__DIR__ . '/../../../../vendor/yiisoft/yii2/Yii.php');
Yii::setAlias('choate/coderelease', dirname(__DIR__));
Yii::setAlias('choateunit/coderelease', __DIR__);
