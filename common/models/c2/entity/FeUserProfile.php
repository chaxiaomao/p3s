<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%fe_user_profile}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $wechat_number
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 * @property string $firstname
 * @property string $lastname
 * @property string $birthday
 * @property string $avatar
 * @property string $address
 * @property integer $terms
 * @property string $qr_code
 * @property string $qr_code_image
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class FeUserProfile extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fe_user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position'], 'integer'],
            [['bio', 'address'], 'string'],
            [['birthday', 'address', 'created_at', 'updated_at'], 'safe'],
            [['name', 'public_email', 'gravatar_email', 'gravatar_id', 'location', 'website', 'timezone', 'firstname', 'lastname', 'avatar', 'qr_code', 'qr_code_image'], 'string', 'max' => 255],
            [['wechat_number'], 'string', 'max' => 10],
            [['terms', 'status'], 'integer', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'user_id' => Yii::t('app.c2', 'User ID'),
            'name' => Yii::t('app.c2', 'Name'),
            'wechat_number' => Yii::t('app.c2', 'Wechat Number'),
            'public_email' => Yii::t('app.c2', 'Public Email'),
            'gravatar_email' => Yii::t('app.c2', 'Gravatar Email'),
            'gravatar_id' => Yii::t('app.c2', 'Gravatar ID'),
            'location' => Yii::t('app.c2', 'Location'),
            'website' => Yii::t('app.c2', 'Website'),
            'bio' => Yii::t('app.c2', 'Bio'),
            'timezone' => Yii::t('app.c2', 'Timezone'),
            'firstname' => Yii::t('app.c2', 'Firstname'),
            'lastname' => Yii::t('app.c2', 'Lastname'),
            'fullname' => Yii::t('app.c2', 'Fullname'),
            'birthday' => Yii::t('app.c2', 'Birthday'),
            'avatar' => Yii::t('app.c2', 'Avatar'),
            'terms' => Yii::t('app.c2', 'Terms'),
            'qr_code' => Yii::t('app.c2', 'Qr Code'),
            'qr_code_image' => Yii::t('app.c2', 'Qr Code Image'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'address' => Yii::t('app.c2', 'Address'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\FeUserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\FeUserProfileQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function beforeSave($insert) {
        // $this->fullname = $this->firstname . $this->lastname;
        return parent::beforeSave($insert);
    }

    public function getUser() {
        return $this->hasOne(FeUser::className(), ['id' => 'user_id']);
    }

    public function synRegionData()
    {
        $provinceName = RegionProvince::find()->select('label')->where(['id' => $this->user->province_id])->scalar();
        $cityName = RegionCity::find()->select('label')->where(['id' => $this->user->city_id])->scalar();
        $districtName = RegionDistrict::find()->select('label')->where(['id' => $this->user->district_id])->scalar();
        $address = $provinceName . $cityName . $districtName . $this->location;
        return $this->updateAttributes(['address' => $address]);
    }

}
