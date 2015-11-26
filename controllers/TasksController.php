<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\controllers;

use choate\coderelease\components\Common;
use choate\coderelease\components\Controller;
use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\services\TasksService;
use choate\coderelease\models\services\WebsiteService;
use yii\helpers\Json;
use yii\rest\Serializer;

/**
 * Class TasksController
 * @package choate\coderelease\controllers
 * @author Choate <choate.yao@gmail.com>
 */
class TasksController extends Controller
{
    /**
     * @var TasksService
     *
     * @author Choate <choate.yao@gmail.com>
     */
    protected $_tasksService;

    public function init() {
        $this->_tasksService = new TasksService();
    }

    public function actionIndex($id) {
        WebsiteService::checkAccess($id);
        $dataProvider = Tasks::find()->getListByWebsite($id, ['sort' => ['attributes' => ['id'], 'defaultOrder' => ['id' => SORT_DESC]]]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id]);
    }

    public function actionCreate($id) {
        WebsiteService::checkAccess($id);
        $request = \Yii::$app->request;
        $form = $this->_tasksService->apply($id, $request->post('TasksForm', null));
        if ($request->getIsPost() && !$form->hasErrors()) {
            return $this->render('success', ['version' => $form->hash]);
        }

        return $this->render('create', ['model' => $form]);
    }

    public function actionPass($id) {
        /* @var Tasks $model */
        $model = Tasks::find()->getById($id);
        WebsiteService::checkAccess($model->websites_id);
        $this->_tasksService->audit($model);

        return Json::encode(['status' => !$model->hasErrors()]);
    }
}