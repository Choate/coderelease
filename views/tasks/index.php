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
echo Html::a('创建任务', ['tasks/create', 'id' => $id], ['class' => 'btn btn-primary', 'style' => 'margin-bottom:10px']);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'       => '{items}',
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
                    'pass' => function ($url, $model) {
                        return $model->getIsApply() ? Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-check']), $url, ['title' => '审核', 'class' => 'task-pass']) : '';
                    },
                ],
            ],
        ],
    ]
);
$this->registerJs(<<<EOF
$('.task-pass').click(function(){
    var url = $(this).attr('href');
    layer.confirm('审核通过之后不允许再提交文件?', {icon: 3, title:'提示'}, function(index){
        layer.close(index);
        var loadIndex = layer.load(1);
        $.get(url, function() {
            layer.msg('审核成功', {icon: 1, time:1000}, function() {
                location.reload();
            });
        }).fail(function() {
            layer.msg('审核失败', {icon: 2, time:1000});
        }).always(function() {
            layer.close(loadIndex);
        });
    });

    return false;
});
EOF
);