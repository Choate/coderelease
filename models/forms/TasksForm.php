<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\forms;

use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\entities\Websites;
use yii\base\DynamicModel;

/**
 * Class TasksForm
 * @property int    $id
 * @property string $title
 * @property string $hash
 * @property int    $apply_time
 * @property int    $applicant
 * @property int    $auditor
 * @property int    $audit_time
 * @property int    $websites_id
 * @property int    $status
 * @package choate\coderelease\models\forms
 * @author Choate <choate.yao@gmail.com>
 */
class TasksForm extends DynamicModel
{
    /**
     * @var Tasks
     * @author Choate <choate.yao@gmail.com>
     */
    private $_model;

    /**
     * @inheritDoc
     */
    public function __construct(array $config = []) {
        $this->_model = new Tasks();
        parent::__construct($this->_model->attributes(), $config);
    }

    public function scenarios() {
        return [
            'apply' => ['websites_id', 'title', '!status', '!apply_time', '!applicant', '!hash'],
        ];
    }

    public function rules() {
        return [
            [['title', 'websites_id'], 'required', 'on' => 'apply'],
            ['websites_id', 'exist', 'targetClass' => Websites::className(), 'targetAttribute' => 'id', 'on' => 'apply'],
            ['status', 'default', 'value' => Tasks::STATUS_APPLY, 'on' => 'apply'],
            ['apply_time', 'default', 'value' => time(), 'on' => 'apply'],
            ['applicant', 'default', 'value' => (int)\Yii::$app->user->id, 'on' => 'apply'],
            ['hash', 'default', 'value' => $this->generatorVersion(), 'on' => 'apply'],
        ];
    }

    protected function generatorVersion() {
        return md5(uniqid());
    }
}