<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'deploy-form']);
echo $form->field($model, 'tasks_id')->dropDownList(ArrayHelper::map($tasks, 'id', 'title'), ['multiple' => true]);
echo Html::submitButton('开始部署', ['class' => 'btn btn-primary start-deploy']);
$form->end();
$url = Url::current();
$this->registerJs(<<<EOF
    $('#deploy-form').on('beforeSubmit', function(event) {
        $('.start-deploy').attr('disabled', true);
        $('#deploy-form').after('<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">0%</div></div>');
        $('.progress').animate({
            opacity : 1
        },{
            duration : 1000,
            progress: function(a, p, c) {
                var progress = Math.round(100 * p);
                var progressText = (progress >= 100 ? 99 : progress) + '%';
                $('.progress-bar').css('width', progressText);
                $('.progress-bar').html(progressText);
            }
        });
        $.post($('#deploy-form').attr('action'), $('#deploy-form').serialize(), function(data) {
            $('#deploy-form').after('<div class="alert alert-success deploy-success" style="display:none;" role="alert"><strong>部署成功</strong> 两秒后自动刷新!</div>');
            $('.deploy-success').fadeIn(200).delay(4000).fadeOut(400);
            setTimeout(function() {location.href='{$url}';}, 2000);
        }, 'json').fail(function(jqXHR, textStatus) {
            $('#deploy-form').after('<div class="alert alert-danger deploy-error" style="display:none;" role="alert"><strong>部署失败：</strong>'+jqXHR.responseJSON.message+'</div>');
            $('.deploy-error').fadeIn(200).delay(4000).fadeOut(400);
            setTimeout(function(){ $('.deploy-error').remove();}, 4800);
            $('.start-deploy').removeAttr('disabled');
        }).always(function() {
            $('.progress').finish();
            $('.progress-bar').css('width', '100%').html('100%')
            setTimeout(function(){ $('.progress').remove();}, 800);
        });
        event.result = false;
    });
EOF
);
?>
