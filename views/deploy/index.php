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

echo Html::a('创建部署', ['deploy', 'id' => $id], ['class' => 'btn btn-primary', 'style' => 'margin-bottom:10px']);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns'      => [
            'id',
            'deploy_time:datetime',
            'deploy_version',
            'statusName',
            [
                'class'    => ActionColumn::className(),
                'template' => "{rollback}\n{redeploy}",
                'buttons'  => [
                    'rollback' => function ($url, $model) {
                        return $model->getIsDeploy() ? Html::a(\yii\bootstrap\Html::icon('share-alt'), $url, ['title' => '回滚']) : '';
                    },
                    'redeploy' => function ($url, $model) {
                        return $model->getIsRollback() ? Html::a(\yii\bootstrap\Html::icon('refresh'), $url, ['title' => '重新部署']) : '';
                    }
                ],
            ],
        ],
    ]
);