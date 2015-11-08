<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\forms;

use choate\coderelease\models\entities\Deploy;
use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\entities\Websites;
use yii\base\DynamicModel;

/**
 * Class DeployForm
 * @package choate\coderelease\models\forms
 * @author Choate <choate.yao@gmail.com>
 */
class DeployForm extends DynamicModel
{
    /**
     * @var Deploy
     * @author Choate <choate.yao@gmail.com>
     */
    private $_model;

    /**
     * @inheritDoc
     */
    public function __construct($config = []) {
        $this->_model = new Deploy();
        parent::__construct(array_merge($this->_model->attributes(), ['tasks_id']), $config);
    }

    /**
     * @inheritDoc
     */
    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['websites_id', 'tasks_id', '!status', '!deployer', '!deploy_time'],
        ];
    }


    public function rules() {
        return [
            [['websites_id', 'tasks_id'], 'required'],
            ['websites_id', 'exist', 'targetClass' => Websites::className(), 'targetAttribute' => 'id'],
            ['tasks_id', 'exist', 'targetClass' => Tasks::className(), 'targetAttribute' => 'id', 'allowArray' => true, 'filter' => function($query) {return $query->isPass();}],
            ['deployer', 'default', 'value' => (int)\Yii::$app->user->id],
            ['deploy_time', 'default', 'value' => time()],
            ['status', 'default', 'value' => Deploy::DEPLOY_SUCCESS],
        ];
    }


}