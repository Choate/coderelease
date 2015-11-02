<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
use yii\helpers\Html;

?>
<div class="jumbotron">
    <h3>创建完成</h3>
    <div class="alert alert-success" role="alert">请复制序列号，作为SVN提交日志：<strong><?php echo $version ?></strong></div>
    <p><?php echo Html::a('返回首页', ['/code'], ['class' => 'btn btn-primary btn-lg']); ?></p>
</div>
