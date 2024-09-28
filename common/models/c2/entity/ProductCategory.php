<?php

namespace common\models\c2\entity;

use common\models\c2\statics\EntityReleaseStatus;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product_category}}".
 *
 * @property string $id
 * @property string $eshop_id
 * @property integer $type
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property integer $lvl
 * @property integer $selected
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 * @property integer $disabled
 * @property integer $active
 * @property string $code
 * @property string $name
 * @property string $label
 * @property string $description
 * @property string $icon
 * @property integer $icon_type
 * @property string $created_by
 * @property string $updated_by
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductCategory extends \cza\base\models\entity\EntityTree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eshop_id', 'root', 'lft', 'rgt', 'lvl', 'created_by', 'updated_by', 'position'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'selected', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'disabled', 'active', 'icon_type', 'status'], 'integer', 'max' => 4],
            [['code', 'name', 'label', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'eshop_id' => Yii::t('app.c2', 'Eshop ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'root' => Yii::t('app.c2', 'Root'),
            'lft' => Yii::t('app.c2', 'Lft'),
            'rgt' => Yii::t('app.c2', 'Rgt'),
            'lvl' => Yii::t('app.c2', 'Lvl'),
            'selected' => Yii::t('app.c2', 'Selected'),
            'readonly' => Yii::t('app.c2', 'Readonly'),
            'visible' => Yii::t('app.c2', 'Visible'),
            'collapsed' => Yii::t('app.c2', 'Collapsed'),
            'movable_u' => Yii::t('app.c2', 'Movable U'),
            'movable_d' => Yii::t('app.c2', 'Movable D'),
            'movable_l' => Yii::t('app.c2', 'Movable L'),
            'movable_r' => Yii::t('app.c2', 'Movable R'),
            'removable' => Yii::t('app.c2', 'Removable'),
            'removable_all' => Yii::t('app.c2', 'Removable All'),
            'disabled' => Yii::t('app.c2', 'Disabled'),
            'active' => Yii::t('app.c2', 'Active'),
            'code' => Yii::t('app.c2', 'Code'),
            'name' => Yii::t('app.c2', 'Name'),
            'label' => Yii::t('app.c2', 'Label'),
            'description' => Yii::t('app.c2', 'Description'),
            'icon' => Yii::t('app.c2', 'Icon'),
            'icon_type' => Yii::t('app.c2', 'Icon Type'),
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
     * @return \common\models\c2\query\ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductCategoryQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public static function getRoot() {
        return static::findByCondition(['lft' => 1, 'status' => EntityModelStatus::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->one();
    }

    public static function getRootByCode($code) {
        return static::findOne(['code' => $code, 'lft' => 1, 'status' => EntityModelStatus::STATUS_ACTIVE]);
    }

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            \yii\behaviors\BlameableBehavior::className(), // record created_by and updated_by
            'attachmentsBehavior' => [
                'class' => \cza\base\modules\Attachments\behaviors\AttachmentBehavior::className(),
                'attributesDefinition' => [
                    'avatar' => [
                        'class' => EntityAttachmentImage::className(),
                        'validator' => 'image',
                        'rules' => [
                            'maxFiles' => 1,
                            'extensions' => Yii::$app->params['config']['upload']['imageWhiteExts'],
                            'maxSize' => Yii::$app->params['config']['upload']['maxFileSize'],
                        ]
                    ],
                ],
            ],
        ]);
    }

    public function afterDelete() {
        $this->unlinkAll("products", true);
        parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes) {
        $this->position = 0;
        parent::afterSave($insert, $changedAttributes);
    }

    public function getProducts($condition = []) {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('{{%product_category_rs}}', ['category_id' => 'id'])
            ->where(['status' => EntityModelStatus::STATUS_ACTIVE])
            // ->andWhere(['is_released' => EntityReleaseStatus::STATUS_YES])
            ->andWhere($condition)
            ->orderBy(['position' => SORT_DESC]);
    }

    public function getProduct() {
        $productIds = ArrayHelper::getColumn(ProductCategoryRs::find()->andWhere(['category_id' => $this->id])->all(), 'product_id');
        $products = Product::find()->andWhere(['id' => $productIds])->all();
        return $products;
    }


}
