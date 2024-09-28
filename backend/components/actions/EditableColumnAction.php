<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @version   3.1.6
 */

namespace backend\components\actions;

use Yii;
use Closure;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rest\Action;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use kartik\grid\EditableColumnAction as BaseModel;

/**
 * EditableAction is useful for processing the update of [[EditableColumn]] attributes via form submission. A typical
 * usage of this action in your controller could look like below:
 *
 * ```php
 *
 * // you can set the EditableColumn::editableOptions['formOptions']['action'] to point to the action below
 * // i.e. `/site/editbook` for the example below
 *
 * use kartik\grid\EditableColumnAction;
 * use yii\web\Controller;
 * use yii\helpers\ArrayHelper;
 * use app\models\Book;
 *
 * class SiteController extends Controller
 * {
 *    public function actions()
 *    {
 *        return array_replace_recursive(parent::actions(), [
 *            'editbook' => [                                   // identifier for your editable column action
 *                'class' => EditableColumnAction::className(), // action class name
 *                'modelClass' => Book::className(),            // the model for the record being edited
 *                'scenario' => Model::SCENARIO_DEFAULT,        // model scenario assigned before validation & update
 *                'outputValue' => function ($model, $attribute, $key, $index) {
 *                      return (int) $model->$attribute / 100;  // return a calculated output value if desired
 *                },
 *                'outputMessage' => function($model, $attribute, $key, $index) {
 *                      return '';                              // any custom error to return after model save
 *                },
 *                'showModelErrors' => true,                    // show model validation errors after save
 *                'errorOptions' => ['header' => '']            // error summary HTML options
 *                // 'postOnly' => true,
 *                // 'ajaxOnly' => true,
 *                // 'findModel' => function($id, $action) {},
 *                // 'checkAccess' => function($action, $model) {}
 *            ]
 *        ]);
 *    }
 * }
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class EditableColumnAction extends BaseModel {

    public $onlyUpdate = true;

    /**
     * Validates the EditableColumn post request submission
     *
     * @return array the output for the Editable action response
     * @throws BadRequestHttpException
     */
    protected function validateEditable() {
        $request = Yii::$app->request;
        if ($this->postOnly && !$request->isPost || $this->ajaxOnly && !$request->isAjax) {
            throw new BadRequestHttpException('This operation is not allowed!');
        }
        $this->initErrorMessages();
        $post = $request->post();
        if (!isset($post['hasEditable'])) {
            return ['output' => '', 'message' => $this->errorMessages['invalidEditable']];
        }
        /**
         * @var ActiveRecord $model
         */
        $key = ArrayHelper::getValue($post, 'editableKey');
        $model = $this->findModel($key);
        if (!$model) {
            return ['output' => '', 'message' => $this->errorMessages['invalidModel']];
        }
        if ($this->checkAccess && is_callable($this->checkAccess)) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $model->scenario = $this->scenario;
        $index = ArrayHelper::getValue($post, 'editableIndex');
        $attribute = ArrayHelper::getValue($post, 'editableAttribute');
        $formName = isset($this->formName) ? $this->formName : $model->formName();
        if (!$formName || is_null($index) || !isset($post[$formName][$index])) {
            return ['output' => '', 'message' => $this->errorMessages['editableException']];
        }
        $postData = [$model->formName() => $post[$formName][$index]];

        if ($this->onlyUpdate) {
            $model->updateAttributes($post[$formName][$index]);
            return ['output' => '', 'message' => ''];
        }

        if ($model->load($postData)) {
            $params = [$model, $attribute, $key, $index];
            $message = static::parseValue($this->outputMessage, $params);

            if (!$model->save()) {
                if (!$model->hasErrors()) {
                    return ['output' => '', 'message' => $this->errorMessages['saveException']];
                }
                if (empty($message) && $this->showModelErrors) {
                    $message = Html::errorSummary($model, $this->errorOptions);
                }
            }
            $value = static::parseValue($this->outputValue, $params);
            return ['output' => $value, 'message' => $message];
        }
        return ['output' => '', 'message' => ''];
    }

    /**
     * Initializes the error messages if not set.
     */
    protected function initErrorMessages() {
        $this->errorMessages += [
            'invalidEditable' => Yii::t('kvgrid', 'Invalid or bad editable data'),
            'invalidModel' => Yii::t('kvgrid', 'No valid editable model found'),
            'editableException' => Yii::t('kvgrid', 'Invalid editable index or model form name'),
            'saveException' => Yii::t('kvgrid', 'Failed to update editable data due to an unknown server error'),
        ];
    }

}
