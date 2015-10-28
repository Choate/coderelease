<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
$config = [
    'components' => [
        'db' => [
            'class'    => '\yii\db\Connection',
            'dsn'      => 'mysql:host=127.0.0.1;dbname=yii_test',
            'username' => 'root',
            'password' => 'shunran',
            'charset'  => 'utf8',
        ],
    ],
];
if (is_file(__DIR__ . '/config.local.php')) {
    include(__DIR__ . '/config.local.php');
}
return $config;