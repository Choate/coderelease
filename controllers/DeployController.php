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
use choate\coderelease\models\services\DeployService;
use choate\coderelease\models\services\WebsiteService;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class DeployController
 * @package choate\coderelease\controllers
 * @author Choate <choate.yao@gmail.com>
 */
class DeployController extends Controller
{

    public function actionIndex($id) {
        WebsiteService::checkAccess($id);
        $dataProvider = Deploy::find()->getItemByWebsite($id);

        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id]);
    }

    public function actionDeploy($id) {
        WebsiteService::checkAccess($id);
        $tasks   = Tasks::find()->byWebsite($id)->isPass()->all();
        $service = new DeployService();
        $model   = $service->deploy($id, \Yii::$app->request->post('DeployForm'));

        return $this->render('deploy', ['model' => $model, 'tasks' => $tasks]);
    }

    public function actionRollback($id) {
        $model   = Deploy::find()->getById($id);
        WebsiteService::checkAccess($model->websites_id);
        $service = new DeployService();
        $service->rollback($model);

        return Json::encode(['status' => 1]);
    }

    public function actionRedeploy($id) {
        $model   = Deploy::find()->getById($id);
        WebsiteService::checkAccess($model->websites_id);
        $tasks   = Tasks::find()->byWebsite($model->websites_id)->isPass()->all();
        $service = new DeployService();
        $form    = $service->redeploy($model, \Yii::$app->request->post('DeployForm'));

        return $this->render('deploy', ['model' => $form, 'tasks' => $tasks]);
    }
}