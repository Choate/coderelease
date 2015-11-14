<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\models\forms;

use choate\coderelease\models\entities\Websites;
use yii\base\DynamicModel;

/**
 * Class WebsiteForm
 * @package choate\coderelease\models\forms
 * @author Choate <choate.yao@gmail.com>
 */
class WebsiteForm extends DynamicModel
{
    /**
     * @var Websites
     * @author Choate <choate.yao@gmail.com>
     */
    private $_model;

    /**
     * @inheritDoc
     */
    public function __construct(array $config = []) {
        $this->_model = new Websites();
        parent::__construct(['name', 'user_id', 'deploy_script', 'deploy_project', 'website'], $config);
    }

    public function rules() {
        return [
            [['name', 'deploy_script', 'website', 'deploy_project'], 'required'],
            ['website', 'url'],
            ['user_id', 'match', 'pattern' => '#^\d+(,\d+)*$#'],
        ];
    }
}