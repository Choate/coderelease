<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use choate\coderelease\components\LayerAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

LayerAsset::register($this);
echo Html::a('创建部署', ['deploy', 'id' => $id], ['class' => 'btn btn-primary', 'style' => 'margin-bottom:10px']);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'       => "{items}\n{pager}",
        'afterRow'     => function ($model, $key, $index, $grid) {
            $content = [];
            foreach ($model->taskItem as $task) {
                $content[] = Html::tag('div', $task->title, ['class' => 'task-title']);
            }

            return Html::tag('tr', Html::tag('td', implode("\n", $content), ['colspan' => 4]));
        },
        'columns'      => [
            'deploy_version',
            'statusName',
            'deploy_time:datetime',
            [
                'header' => '操作',
                'class'    => ActionColumn::className(),
                'template' => "{rollback}\n{redeploy}\n{test}",
                'buttons'  => [
                    'rollback' => function ($url, $model) {
                        return $model->getIsDeploy() ? Html::a(\yii\bootstrap\Html::icon('share-alt'), $url, ['title' => '回滚', 'class' => 'deploy-rollback']) : '';
                    },
                    'redeploy' => function ($url, $model) {
                        return $model->getIsRollback() ? Html::a(\yii\bootstrap\Html::icon('refresh'), $url, ['title' => '重新部署']) : '';
                    },
                ],
            ],
        ],
    ]
);
$this->registerJs(<<<EOF
$('.deploy-rollback').click(function(){
    var url = $(this).attr('href');
    layer.confirm('回滚任务？', {icon: 3, title:'提示'}, function(index){
        layer.close(index);
        var loadIndex = layer.load(1);
        $.get(url, function() {
            layer.msg('回滚成功', {icon: 1, time:1000}, function() {
                location.reload();
            });
        }).fail(function() {
            layer.msg('回滚失败', {icon: 2, time:1000});
        }).always(function() {
            layer.close(loadIndex);
        });
    });

    return false;
});
EOF
);