<?php

namespace common\models\c2\entity;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $code
 * @property string $label
 * @property string $default_value
 * @property string $custom_value
 * @property string $memo
 * @property string $created_by
 * @property string $updated_by
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Config extends \cza\base\models\ActiveRecord {

    use \common\traits\AttachmentTrait;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%config}}';
    }

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
                    'class' => BlameableBehavior::className(),]);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['code', 'unique', 'on' => self::OP_INSERT],
            [['type', 'created_by', 'updated_by', 'status', 'position'], 'integer'],
            [['code', 'label'], 'required'],
            [['default_value', 'memo'], 'string'],
            [['custom_value', 'created_at', 'updated_at'], 'safe'],
            [['code', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'code' => Yii::t('app.c2', 'Code'),
            'label' => Yii::t('app.c2', 'Label'),
            'default_value' => Yii::t('app.c2', 'Default Value'),
            'custom_value' => Yii::t('app.c2', 'Custom Value'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ConfigQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\c2\query\ConfigQuery(get_called_class());
    }

    /**
     * setup default values
     * */
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getValue() {
        return ($this->custom_value !== '') ? $this->custom_value : $this->default_value;
    }

    public function getSettings() {
        $result = [];
        $settings = static::find()->select(['type', 'code', 'default_value', 'custom_value'])->frequency()->active()->asArray()->all();

        foreach ($settings as $setting) {
            $key = $setting['code'];
            $settingOptions = ['value' => ($setting['custom_value'] != '') ? $setting['custom_value'] : $setting['default_value']];

            if (isset($result[$key])) {
                ArrayHelper::merge($result[$key], $settingOptions);
            } else {
                $result[$key] = $settingOptions;
            }
        }
        return $result;
    }

}
