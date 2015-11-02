<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'statusName',
        [
            'class' => ActionColumn::className(),
            'template' => "{tasks/index}\n{tasks/create}\n{update}",
            'buttons' => [
                'tasks/index' => function ($url) {
                    return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-th-list']), $url, ['title' => '任务列表']);
                },
                'tasks/create' => function ($url, $model) {
                    return !$model->getIsBusy() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), $url, ['title' => '新增任务']) : '';
                }
            ],
        ],
    ],
]);