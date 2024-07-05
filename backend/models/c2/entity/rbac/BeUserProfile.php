<?php

namespace backend\models\c2\entity\rbac;

use Yii;
use yii\web\UploadedFile;
use dektrium\user\models\Profile as BaseModel;

/**
 * This is the model class for table "{{%be_user_profile}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
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
 * @property integer $terms
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class BeUserProfile extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%be_user_profile}}';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['user_id', 'terms', 'status', 'position'], 'integer'],
//            [['bio'], 'string'],
//            [['birthday', 'created_at', 'updated_at'], 'safe'],
//            [['name', 'public_email', 'gravatar_email', 'gravatar_id', 'location', 'website', 'timezone', 'firstname', 'lastname', 'avatar'], 'string', 'max' => 255],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'user_id' => Yii::t('app.c2', 'User ID'),
            'name' => Yii::t('app.c2', 'Nick Name'),
            'public_email' => Yii::t('app.c2', 'Public Email'),
            'gravatar_email' => Yii::t('app.c2', 'Gravatar Email'),
            'gravatar_id' => Yii::t('app.c2', 'Gravatar ID'),
            'location' => Yii::t('app.c2', 'Location'),
            'website' => Yii::t('app.c2', 'Website'),
            'bio' => Yii::t('app.c2', 'Bio'),
            'timezone' => Yii::t('app.c2', 'Timezone'),
            'firstname' => Yii::t('app.c2', 'Firstname'),
            'lastname' => Yii::t('app.c2', 'Lastname'),
            'birthday' => Yii::t('app.c2', 'Birthday'),
            'avatar' => Yii::t('app.c2', 'Avatar'),
            'terms' => Yii::t('app.c2', 'Terms'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return BeUserQuery the active query used by this AR class.
     */
    public static function find() {
        return new BeUserQuery(get_called_class());
    }

    public function scenarios() {
        $scenarios = parent::scenarios();

        // add firstname to scenarios
        $scenarios['create'][] = 'firstname';
        $scenarios['update'][] = 'firstname';
        $scenarios['register'][] = 'firstname';

        // add lastname to scenarios
        $scenarios['create'][] = 'lastname';
        $scenarios['update'][] = 'lastname';
        $scenarios['register'][] = 'lastname';

        // add birthday to scenarios
        $scenarios['create'][] = 'birthday';
        $scenarios['update'][] = 'birthday';
        $scenarios['register'][] = 'birthday';

        // add avatar to scenarios
        $scenarios['create'][] = 'avatar';
        $scenarios['update'][] = 'avatar';
        $scenarios['register'][] = 'avatar';

        return $scenarios;
    }

    public function rules() {
        $rules = parent::rules();

        // add firstname rules
        $rules['firstnameRequired'] = ['firstname', 'required'];
        $rules['firstnameLength'] = ['firstname', 'string', 'max' => 255];

        // add lastname rules
        $rules['lastnameRequired'] = ['lastname', 'required'];
        $rules['lastnameLength'] = ['lastname', 'string', 'max' => 255];

        // add birthday rules
        $rules['birthdayRequired'] = ['birthday', 'required'];
        $rules['birthdayLength'] = ['birthday', 'date', 'format' => 'yyyy-mm-dd'];

        // add terms checkbox
//        $rules['termsRequired'] = ['terms', 'required', 'requiredValue' => true, 'message' => 'You must agree to the terms and conditions'];
//        $rules['termsLength'] = ['terms', 'integer'];

        return $rules;
    }

    /**
     * Upload file
     *
     * @param $filePath
     * @return mixed the uploaded image instance
     */
    public function uploadAvatar($filePath) {
        $file = UploadedFile::getInstance($this, 'avatar');

        // if no file was uploaded abort the upload
        if (empty($file)) {
            return false;
        } else {

            // file extension
            $fileExt = $file->extension;
            // purge filename
            $fileName = \Yii::$app->security->generateRandomString();
            // update file->name
            $file->name = $fileName . ".{$fileExt}";
            // update avatar field
            $this->avatar = $fileName . ".{$fileExt}";

            // save images to imagePath
            if (!file_exists($filePath)) {
                if (!@mkdir($filePath, 0775, true)) {
                    throw new Exception("Cannot create dir: {$filePath}");
                }
            }
            $file->saveAs($filePath . '/' . $fileName . ".{$fileExt}");

            // the uploaded file instance
            return $file;
        }
    }

    /**
     * fetch stored image file name with complete path
     *
     * @return string
     */
    public function getImagePath() {
        return $this->avatar ? \Yii::getAlias(\Yii::$app->getModule('user')->avatarPath) . '/' . $this->avatar : null;
    }

    /**
     * fetch stored image url
     *
     * @return string
     */
    public function getImageUrl() {
        if (!is_null($this->getAccountAttributes()) && !$this->avatar) {
            $imageURL = $this->getSocialImage();
        } else {

            $avatar = $this->avatar ? $this->avatar : 'default.png';
            $imageURL = \Yii::getAlias(\Yii::$app->getModule('user')->avatarURL) . '/' . $avatar;
        }

        return $imageURL;
    }

    public function getFullname() {
        return $this->firstname . $this->lastname;
    }

    /**
     * for avatar preview
     * @return type
     */
    public function getInitialPreview() {
        $initialPreview = [];
        $initialPreview[] = yii\helpers\Html::img($this->getImageUrl(), ['class' => 'file-preview-image']);
        return $initialPreview;
    }

    /**
     * for avatar preview
     * @return type
     */
    public function getInitialPreviewConfig() {
        $initialPreviewConfig = [];

        $initialPreviewConfig[] = [
            'caption' => $this->avatar,
            'size' => \filesize($this->getImagePath()),
            'url' => $this->getImageUrl(),
        ];

        return $initialPreviewConfig;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage($avatarOld) {
        $avatarURL = \Yii::getAlias(\Yii::$app->getModule('user')->avatarPath) . $avatarOld;

        // check if file exists on server
        if (empty($avatarURL) || !file_exists($avatarURL)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($avatarURL)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;

        return true;
    }

    public function getSocialImage() {
        $imageURL = "";
        $account = $this->getAccountAttributes();

        switch ($account['provider']) {
            case "facebook":
                $imageURL = "https://graph.facebook.com/" . $account['client_id'] . "/picture?type=large";
                break;
        }

        return $imageURL;
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getAccount() {
        // return $this->hasOne($this->module->modelMap['Account'], ['user_id' => 'user_id']);
    }

    public function getMemberName() {
        return !empty($this->fullname) ? $this->fullname :( !empty($this->name) ? $this->name : $this->firstname .$this->lastname);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getAccountAttributes() {
        // return $this->hasOne($this->module->modelMap['Account'], ['user_id' => 'user_id'])->asArray()->one();
    }

}
