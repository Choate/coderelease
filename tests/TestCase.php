<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choateunit\coderelease;

use yii\helpers\ArrayHelper;

/**
 * Class TestCase
 * @package choateunit\vsftpd\tests
 * @author Choate <choate.yao@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function mockApplication($config = [], $appClass = '\yii\console\Application') {
        new $appClass(ArrayHelper::merge([
            'id'         => 'testapp',
            'basePath'   => __DIR__,
            'vendorPath' => $this->getVendorPath(),
        ], $config
        )
        );
    }

    protected function getVendorPath() {
        $vendor = dirname(dirname(dirname(__DIR__))) . '/vendor';
        if (!is_dir($vendor)) {
            $vendor = dirname(dirname(dirname(dirname(__DIR__))));
        }

        return $vendor;
    }

    protected function getConfig() {
        return include __DIR__ . '/data/config.php';
    }

    protected function loadFixture($fixture) {
        if ($fixture !== null) {
            $fixture = __DIR__ . "/data/{$fixture}.sql";
            $lines   = explode(';', file_get_contents($fixture));
            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    \Yii::$app->db->open();
                    \Yii::$app->db->pdo->exec($line);
                }
            }
        }
    }
}

