<?php
/**
 * 邢帅教育
 * 本源代码由邢帅教育及其作者共同所有，未经版权持有者的事先书面授权，
 * 不得使用、复制、修改、合并、发布、分发和/或销售本源代码的副本。
 * @copyright Copyright (c) 2013 xsteach.com all rights reserved.
 */
namespace choate\coderelease\console;

use choate\coderelease\models\entities\Tasks;
use yii\console\Controller;

/**
 * Class CodeReleaseController
 * @package choate\coderelease\console
 * @author Choate <choate.yao@gmail.com>
 */
class CodeReleaseController extends Controller
{
    public function actionStatus($hash) {
        $model = Tasks::find()->getByHash($hash);
        $result = 0;
        if ($model) {
            $result = 1;
        }

        $this->stdout((int)$result);
    }
}