<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use yii\bootstrap\Html;
use yii\widgets\ListView;

echo ListView::widget([
        'dataProvider' => $dataProvider,
        'layout'       => '{items}',
        'options'      => ['class' => 'row'],
        'itemOptions'  => ['class' => 'col-sm-6 col-md-4'],
        'itemView'     => function ($model) {
            return Html::beginTag('div', ['class' => 'thumbnail brand-primary']) .
                   Html::beginTag('div', ['class' => 'caption']) .
                   Html::tag('h3', $model->name, ['class' => 'text-center']) .
                   Html::tag('p', '&nbsp;') .
                   Html::tag('p',
                       Html::a('上线任务', ['tasks/index', 'id' => $model->id], ['class' => 'btn btn-info', 'role' => 'button']) .
                       ' ' .
                       Html::a('部署任务', ['deploy/index', 'id' => $model->id], ['class' => 'btn btn-success', 'role' => 'button'])
                   ) .
                   Html::endTag('div') .
                   Html::endTag('div');
        }
    ]
);
?>
