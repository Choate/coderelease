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

echo Html::a('创建任务', ['tasks/create', 'id' => $id], ['class' => 'btn btn-primary', 'style' => 'margin-bottom:10px']);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns'      => [
            'id',
            'title',
            'hash',
            'apply_time:datetime',
            'statusName',
            [
                'class'    => ActionColumn::className(),
                'template' => "{pass}",
                'buttons'  => [
                    'pass'     => function ($url, $model) {
                        return $model->getIsApply() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-check']), $url, ['title' => '审核']) : '';
                    },
                    'version-file' => function ($url) {
                        return Html::a(\yii\bootstrap\Html::icon('eye-open'), $url, ['title' => '查看文件']);
                    }
                ],
            ],
        ],
    ]
);