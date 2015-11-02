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
    'columns'      => [
        'id',
        'title',
        'hash',
        'statusName',
        [
            'class'    => ActionColumn::className(),
            'template' => "{publish}\n{pass}\n{rollback}",
            'buttons'  => [
                'publish'  => function ($url, $model) {
                    return $model->getIsPass() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cloud-upload']), $url, ['title' => '发布任务']) : '';
                },
                'pass'     => function ($url, $model) {
                    return $model->getIsApply() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-check']), $url, ['title' => '审核']) : '';
                },
                'rollback' => function ($url, $model) {
                    return $model->getIsPublish() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cloud-download']), $url, ['title' => '回滚任务']) : '';
                }
            ],
        ],
    ],
]
);