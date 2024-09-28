<?php

namespace backend\models\c2\form\Config;

use Yii;
use yii\base\Model;
use common\models\c2\entity\Config;
use yii\web\NotFoundHttpException;
use cza\base\models\ModelTrait;
use yii\helpers\Inflector;
use common\models\c2\statics\ConfigType;
use yii\base\ModelEvent;

/**
 * Form represents the model behind the search form about `common\models\c2\entity\CmsPage`.
 */
abstract class Form extends Model {

    /**
     * @event ModelEvent an event that is triggered before inserting a record.
     * You may set [[ModelEvent::isValid]] to be `false` to stop the insertion.
     */
    const EVENT_BEFORE_SAVE = 'beforeSave';

    /**
     * @event AfterSaveEvent an event that is triggered after a record is inserted.
     */
    const EVENT_AFTER_SAVE = 'afterSave';

    protected $_prefix = '';

    use ModelTrait;

    public function init() {
        parent::init();
        $this->loadParams();
    }

    public function getCode($attribute) {
        return !empty($this->_prefix) ? $this->_prefix . '\\' . Inflector::camel2id($attribute, '_') : Inflector::camel2id($attribute, '_');
    }

    public function loadParams() {
        $attributes = $this->attributes;
        foreach ($attributes as $attribute => $v) {
            $code = $this->getCode($attribute);
            $paramModel = $this->findEntityModel($code);
            $this->$attribute = $paramModel->getValue();
//            Yii::info($attribute . ":" . $code . ":" . $this->$attribute);
        }
    }

    public function save() {
        if (!$this->beforeSave()) {
            return false;
        }
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute => $v) {
            $code = $this->getCode($attribute);
            $entityModel = $this->findEntityModel($code);
            if ($entityModel->isNewRecord) {
                $entityModel->label = $this->getAttributeLabel($attribute);
                $entityModel->code = $code;
                $entityModel->type = ConfigType::TYPE_FREQUENCY;
                $entityModel->custom_value = $v;
            } else {
                $entityModel->custom_value = $v;
            }

            if (!$entityModel->save()) {
                $this->addError($attribute, \Yii::t('app.c2', "{s1} cannot be saved. \n Reason: {s2}", [
                            's1' => $attribute,
                            's2' => print_r($entityModel->getErrors(), true),
                ]));
                return false;
            }
        }

        if (Yii::$app->settings) {
            Yii::$app->settings->cleanupCache(Yii::getAlias('@backend') . '/runtime/cache');  // delete backend cache
            Yii::$app->settings->cleanupCache(Yii::getAlias('@frontend') . '/runtime/cache');  // delete frontend cache
            Yii::$app->settings->cleanupCache(Yii::getAlias('@console') . '/runtime/cache');  // delete console cache
            Yii::$app->settings->cleanupCache(Yii::getAlias('@app_eshop') . '/runtime/cache');  // delete eshop cache
        }
        $this->afterSave();
        return true;
    }

    public function beforeSave() {
        $event = new ModelEvent();
        $this->trigger(self::EVENT_BEFORE_SAVE, $event);

        return $event->isValid;
    }

    public function afterSave() {
        $event = new ModelEvent();
        $this->trigger(self::EVENT_AFTER_SAVE, $event);
    }

    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Config the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findEntityModel($code) {
        if (($model = Config::findOne(['code' => $code])) !== null) {
            return $model;
        } else {
            $model = new Config(['code' => $code]);
            return $model;
        }
    }

    public function getEntityByAttribute($attribute) {
        $code = $this->getCode($attribute);
        $entityModel = $this->findEntityModel($code);
        if ($entityModel->isNewRecord) {
            $entityModel->label = $this->getAttributeLabel($attribute);
            $entityModel->code = $code;
            $entityModel->type = ConfigType::TYPE_FREQUENCY;
            $entityModel->save();
            $entityModel->refresh();
        }
        return $entityModel;
    }

    public function getEntityAttributeId($attribute) {
        return $this->getEntityByAttribute($attribute)->id;
    }

}
