<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

/* @var \yii\web\View $this */
$form = ActiveForm::begin();
echo $this->render('_form', ['model' => $model, 'form' => $form]);
echo Button::widget([
        'label' => '更新配置',
        'options' => ['class' => 'btn-primary'],
    ]
);
$form->end();