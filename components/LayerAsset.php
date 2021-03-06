<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\components;

use yii\web\AssetBundle;

/**
 * Class LayerAsset
 * @package choate\coderelease\components
 * @author Choate <choate.yao@gmail.com>
 */
class LayerAsset extends AssetBundle
{
    public $sourcePath = '@bower/layer';

    public $js = [
        'layer.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}