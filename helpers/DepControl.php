<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\helpers;

use Symfony\Component\Process\Process;
use yii\base\InvalidParamException;
use yii\base\Object;

/**
 * Class DepControl
 * @package choate\coderelease\helpers
 * @author Choate <choate.yao@gmail.com>
 */
class DepControl extends Object
{
    public $deployScript;
    public $deployProject;

    public function init() {
        if (empty($this->deployScript) || empty($this->deployProject)) {
            throw new InvalidParamException('无效的参数 deployScript 或 deployProject');
        }
    }

    /**
     * @param array $config
     *
     * @since 1.0
     * @author Choate <choate.yao@gmail.com>
     * @return DepControl
     * @throws \yii\base\InvalidConfigException
     */
    public static function run(array $config = []) {
        $object = \Yii::createObject(array_merge($config, ['class' => DepControl::className()]));
        if (!empty($config)) {
            \Yii::configure($object, $config);
        }

        return $object;
    }

    protected function runCommand($command) {
        $process = new Process($command);
        $exec    = $process->setCommandLine('whereis dep')->mustRun()->getOutput();

        return $process->setCommandLine(sprintf('php %s --file=%s %s %s', trim(substr($exec, strpos($exec, '/'))), $this->deployScript, $command, $this->deployProject))
            ->mustRun()->getOutput();
    }

    public function deploy($hash, $message) {
        return $this->runCommand(sprintf('--hash="%s" --message="%s" deploy', $hash, $message));
    }

    public function rollback($version) {
        return $this->runCommand(sprintf('--revision="%s" rollback', $version));
    }

    public function current() {
        $result = $this->runCommand('current');
        list(,,$version,) = explode(PHP_EOL, $result);

        return $version;
    }
}