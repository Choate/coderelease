<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\controllers;

use choate\coderelease\components\Controller;
use choate\coderelease\models\entities\WebsiteHasUser;
use choate\coderelease\models\entities\Websites;
use choate\coderelease\models\forms\WebsiteForm;
use yii\filters\AccessControl;

/**
 * Class WebsitesController
 * @package choate\coderelease\controllers
 * @author Choate <choate.yao@gmail.com>
 */
class WebsitesController extends Controller
{

    public function actionIndex() {
        $dataProvider = Websites::find()->provider(['pagination' => false]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $form = new WebsiteForm();
        if ($form->load($_POST) && $form->validate()) {
            $model = new Websites();
            $model->on(Websites::EVENT_AFTER_INSERT, function($event) use ($form) {
                $model = $event->sender;
                if ($form->user_id) {
                    WebsiteHasUser::batchInsertByCondition(['user_id'], explode(',', $form->user_id), ['website_id' => $model->id]);
                }
            });
            $model->setAttributes($form->getAttributes(null, ['user_id']), false);
            $model->insert(false);

            return $this->redirect('index');
        }

        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id) {
        /* @var Websites $model */
        $model = Websites::findOne($id);
        $form  = new WebsiteForm();
        if ($form->load($_POST) && $form->validate()) {
            $model->setAttributes($form->getAttributes(null, ['user_id']), false);
            $model->on(Websites::EVENT_AFTER_UPDATE, function($event) use ($form) {
                $model = $event->sender;
                WebsiteHasUser::deleteAll(['website_id' => $model->id]);
                if ($form->user_id) {
                    WebsiteHasUser::batchInsertByCondition(['user_id'], explode(',', $form->user_id), ['website_id' => $model->id]);
                }
            });
            $model->update(false);

            return $this->redirect('index');
        }
        $form->setAttributes($model->getAttributes());

        return $this->render('update', ['model' => $form]);
    }

}