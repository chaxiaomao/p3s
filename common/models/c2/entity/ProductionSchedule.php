<?php

namespace common\models\c2\entity;

use backend\models\c2\entity\ProductCommitNote;
use backend\models\c2\entity\rbac\BeUser;
use common\helpers\CodeGenerator;
use common\models\c2\statics\ProductionCommitNoteType;
use common\models\c2\statics\ProductionScheduleState;
use common\models\c2\statics\WarehouseNoteType;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "{{%production_schedule}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $code
 * @property string $label
 * @property string $producer
 * @property string $dept_manager_name
 * @property string $financial_name
 * @property string $occurrence_date
 * @property string $accomplish_date
 * @property string $memo
 * @property string $updated_by
 * @property string $created_by
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $updated_at
 * @property string $created_at
 */
class ProductionSchedule extends \cza\base\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%production_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['occurrence_date', 'accomplish_date', 'updated_at', 'created_at',], 'safe'],
            [['updated_by', 'created_by', 'position'], 'integer'],
            [['memo',], 'string'],
            [['type', 'state', 'status'], 'integer', 'max' => 4],
            [['code', 'label', 'dept_manager_name', 'financial_name', 'producer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'code' => Yii::t('app.c2', 'Code'),
            'label' => Yii::t('app.c2', 'Label'),
            'dept_manager_name' => Yii::t('app.c2', 'Dept Manager Name'),
            'financial_name' => Yii::t('app.c2', 'Financial Name'),
            'occurrence_date' => Yii::t('app.c2', 'Occurrence Date'),
            'accomplish_date' => Yii::t('app.c2', 'Accomplish Date'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'producer' => Yii::t('app.c2', 'Producer'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'created_at' => Yii::t('app.c2', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ProductionScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductionScheduleQuery(get_called_class());
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getScheduleItems()
    {
        return $this->hasMany(ProductionScheduleItem::className(), ['schedule_id' => 'id']);
    }


    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            BlameableBehavior::className()
        ]);
    }

    public function getCreator()
    {
        return $this->hasOne(BeUser::className(), ['id' => 'created_by']);
    }

    public function getUpdator()
    {
        return $this->hasOne(BeUser::className(), ['id' => 'updated_by']);
    }

    public function getScheduleItemConsumption()
    {
        return $this->hasMany(ProductionConsumption::className(), ['schedule_id' => 'id']);
    }

    public function allProductFinish()
    {
        $items = $this->getScheduleItems()
            ->with('productCombination')
            ->all();
        if (!empty($items)) {

            $commitNote = new ProductCommitNote();
            $commitNote->loadDefaultValues();
            $commitNote->schedule_id = $this->id;
            $commitNote->type = ProductionCommitNoteType::PRODUCT_COMMIT;
            $commitNote->save();

            foreach ($items as $item) {
                $comb = $item->productCombination;
                // $comb->stock += $item->production_sum;
                // $comb->save();
                // $item->enter_sum = $item->production_sum;
                // $item->save();
                $attributes = [
                    'note_id' => $commitNote->id,
                    'schedule_id' => $this->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_sku' => $item->product_sku,
                    'product_label' => $item->product_label,
                    'product_value' => $item->product_value,
                    'combination_id' => $comb->id,
                    'combination_name' => $comb->name,
                    'measure_id' => $item->measure_id,
                    'commit_sum' => $item->production_sum,
                    'memo' => isset($item['memo']) ? $item['memo'] : '',
                    'position' => isset($item['position']) ? $item['position'] : 0,
                ];
                $commitItem = new ProductionCommitNoteItem();
                $commitItem->setAttributes($attributes);
                $commitItem->save();

            }
        }
        // $this->updateAttributes(['state' => ProductionScheduleState::FINISH]);
    }

    // public function allMixtureSend()
    // {
    //     $items = $this->getScheduleItemConsumption()->all();
    //     if (!empty($items)) {
    //         foreach ($items as $item) {
    //             $mixture = $item->product;
    //             $mixture->stock -= $item->need_sum;
    //             $mixture->save();
    //             $item->updateCounters(['send_sum' => $item->need_sum]);
    //         }
    //     }
    //     $this->updateAttributes(['state' => ProductionScheduleState::ALL_SEND]);
    // }

    public function allMixtureFinish()
    {
        $items = $this->getScheduleItems()->all();
        if (!empty($items)) {
            foreach ($items as $item) {
                $mixture = $item->product;
                $mixture->stock += $item->production_sum;
                $mixture->save();
                $item->enter_sum = $item->production_sum;
                $item->save();
            }
        }
        $this->updateAttributes(['state' => ProductionScheduleState::FINISH]);
    }

    public function allProcessFinish()
    {
        $items = $this->getScheduleItems()->all();
        if (!empty($items)) {
            foreach ($items as $item) {
                $mixture = $item->product;
                $mixture->stock -= $item->production_sum;
                $mixture->save();

                $enterProd = $item->enterProduct;
                $enterProd->stock += $item->enter_sum;
                $enterProd->save();

                // $item->enter_sum = $item->production_sum;
                // $item->save();
            }
        }
        // $this->updateAttributes(['state' => ProductionScheduleState::FINISH]);
    }

    public function allProductionEnter()
    {
        $note = new WarehouseNote();
        $note->loadDefaultValues();
        $note->ref_note_id = $this->id;
        $note->type = WarehouseNoteType::PRODUCTION;
        $note->ref_note_code = $this->code;
        $items = [];
        foreach ($this->getScheduleItems()->asArray()->all() as $item) {
            $item['id'] = '';
            $items[] = $item;
        }
        $note->items = $items;
        $note->save();
    }
    public function allMixtureSend()
    {
        $note = new WarehouseNote();
        $note->loadDefaultValues();
        $note->ref_note_id = $this->id;
        $note->type = WarehouseNoteType::MIXTURE_SEND;
        $note->ref_note_code = $this->code;
        $items = [];
        foreach ($this->getScheduleItemConsumption()->asArray()->all() as $item) {
            $data = [];
            $data['id'] = '';
            $data['product_id'] = $item['need_product_id'];
            $data['number'] = $item['need_sum'];
            $items[] = $data;
        }
        $note->items = $items;
        if (!$note->save()) {
            Yii::info($note->errors);
        }
    }

}
