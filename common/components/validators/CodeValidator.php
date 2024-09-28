<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\validators;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * CodeValidator validates that the attribute value matches the specified [[pattern]].
 *
 * If the [[not]] property is set true, the validator will ensure the attribute value do NOT match the [[pattern]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CodeValidator extends \yii\validators\RegularExpressionValidator
{
    /**
     * 
     * @var string the regular expression to be matched with
     */
    public $pattern = '/^[a-zA-Z0-9\-\_]+$/';
   
}
