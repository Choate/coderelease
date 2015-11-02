<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\controllers;

use choate\coderelease\components\Controller;
use choate\coderelease\models\entities\Websites;
use choate\coderelease\models\forms\WebsiteForm;

/**
 * Class WebsitesController
 * @package choate\coderelease\controllers
 * @author Choate <choate.yao@gmail.com>
 */
class WebsitesController extends Controller
{
    public function actionIndex() {
        $dataProvider = Websites::find()->provider();

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $form = new WebsiteForm();
        if ($form->load($_POST) && $form->validate()) {
            $model = new Websites();
            $model->setAttributes($form->getAttributes(), false);
            $model->insert(false);

            return $this->redirect('index');
        }

        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id) {
        /* @var Websites $model */
        $model = Websites::findOne($id);
        $form = new WebsiteForm();
        if ($form->load($_POST) && $form->validate()) {
            $model->setAttributes($form->getAttributes($form->safeAttributes()), false);
            $model->update(false);

            return $this->redirect('index');
        }
        $form->setAttributes($model->getAttributes());

        return $this->render('update', ['model' => $form]);
    }

}