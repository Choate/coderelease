<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\controllers;

use choate\coderelease\components\Controller;
use choate\coderelease\models\entities\Deploy;
use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\forms\DeployForm;
use choate\coderelease\models\services\DeployService;

/**
 * Class DeployController
 * @package choate\coderelease\controllers
 * @author Choate <choate.yao@gmail.com>
 */
class DeployController extends Controller
{
    public function actionIndex($id) {
        $dataProvider = Deploy::find()->getItemByWebsite($id);

        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id]);
    }

    public function actionDeploy($id) {
        $tasks = Tasks::find()->byWebsite($id)->isPass()->all();
        $service = new DeployService();
        $model = $service->deploy($id, \Yii::$app->request->post('DeployForm'));

        return $this->render('deploy', ['model' => $model, 'tasks' => $tasks]);
    }

    public function actionRollback($id) {
    }
}