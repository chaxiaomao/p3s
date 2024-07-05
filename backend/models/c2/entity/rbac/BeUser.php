<?php

namespace backend\models\c2\entity\rbac;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User as BaseModel;

/**
 * This is the model class for table "{{%be_user}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $attributeset_id
 * @property string $username
 * @property string $email
 * @property string $mobile_number;
 * @property string $password_hash
 * @property string $auth_key
 * @property string $confirmed_at
 * @property string $unconfirmed_email
 * @property string $blocked_at
 * @property string $registration_ip
 * @property integer $flags
 * @property string $last_login_at
 * @property string $last_login_ip
 * @property string $open_id
 * @property string $created_by
 * @property string $updated_by
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class BeUser extends BaseModel {

    use \cza\base\models\ModelTrait;
    public $mobile_number;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%be_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'attributeset_id', 'flags', 'created_by', 'updated_by', 'status', 'position'], 'integer'],
            [['username', 'email'], 'required'],
            [['confirmed_at', 'blocked_at', 'last_login_at', 'created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip', 'last_login_ip', 'open_id'], 'string', 'max' => 255],
            //mobileNumber rules
            'moblieNumberLength' => ['mobile_number', 'match', 'pattern' => '/^1[0-9]{10}$/', 'message' => \Yii::t('app.c2', 'Must be mobile number'), 'on' => ['register', 'create', 'update']],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function block() {
        return (bool) $this->updateAttributes([
                    'blocked_at' => date('Y-m-d H:i:s'),
                    'auth_key' => \Yii::$app->security->generateRandomString(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'attributeset_id' => Yii::t('app.c2', 'Attributeset ID'),
            'username' => Yii::t('app.c2', 'Username'),
            'email' => Yii::t('app.c2', 'Email'),
            'password' => Yii::t('app.c2', 'Password'),
            'password_hash' => Yii::t('app.c2', 'Password Hash'),
            'auth_key' => Yii::t('app.c2', 'Auth Key'),
            'confirmed_at' => Yii::t('app.c2', 'Confirmed At'),
            'unconfirmed_email' => Yii::t('app.c2', 'Unconfirmed Email'),
            'blocked_at' => Yii::t('app.c2', 'Blocked At'),
            'registration_ip' => Yii::t('app.c2', 'Registration Ip'),
            'flags' => Yii::t('app.c2', 'Flags'),
            'last_login_at' => Yii::t('app.c2', 'Last Login At'),
            'last_login_ip' => Yii::t('app.c2', 'Last Login Ip'),
            'open_id' => Yii::t('app.c2', 'Open ID'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'mobile_number' => Yii::t('app.c2', 'Mobile Number')
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
                    'register' => ['mobile_number'],
                    'create' => ['mobile_number'],
                    'update' => ['mobile_number'],
        ]);
    }

    /**
     * @inheritdoc
     * @return BeUserQuery the active query used by this AR class.
     */
    public static function find() {
        return new BeUserQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile() {
        return $this->hasOne(BeUserProfile::className(), ['user_id' => 'id'])->from(BeUserProfile::tableName() . ' AS profile');
    }

    public function getResearchForm() {
        return $this->hasMany(\common\models\c2\entity\ResearchForm::className(), ['staff_id' => 'id']);
    }

    /**
     * @return user roles
     */
    public function getRoles() {
        return $this->hasMany(Assignment::className(), ['user_id' => 'id'])->from(Assignment::tableName() . ' AS role');
    }

    /**
     * @return user roles from userid
     */
    public function getRulesByUserID($userid) {
        return Yii::$app->authManager->getRolesByUser($userid);
    }

    public function getCustomers() {
        return $this->hasMany(Customer::className(), ['id' => 'customer_id'])
                        ->where(['status' => EntityModelStatus::STATUS_ACTIVE])
                        ->viaTable('{{%staff_customer_rs}}', ['staff_id' => 'id']);
    }

    /**
     * return a format data array for select2 ajax response
     * @param type $keyField
     * @param type $valField
     * @param type $condition
     * @return array
     */
    public static function getOptionsListCallable($keyField, $valField, $condition = '', $params = []) {
        $params = ArrayHelper::merge(['limit' => 10], $params);
        $class = static::className();
        $items = [];
        $models = $class::find()->andWhere($condition)->limit($params['limit'])->all();
        foreach ($models as $model) {
            $items[] = [
                $keyField => $model->$keyField,
                $valField => $model->$valField,
                'text' => $model->$valField,
            ];
        }
        return $items;
    }

    public function getFullName() {
        if (!isset($this->_data['fullname'])) {
            $this->_data['fullname'] = is_null($this->profile) ? "" : $this->profile->getMemberName();
        }
        return $this->_data['fullname'];
    }

    public function getMobileWithName() {
        if (!isset($this->_data['mobileWithName'])) {
            $this->_data['mobileWithName'] = is_null($this->profile) ? "" : $this->mobile_number . " " . $this->username;
        }
        return $this->_data['mobileWithName'];
    }

    public function getResearchFormCount() {
        if (!isset($this->_data['researchFormCount'])) {
            $this->_data['researchFormCount'] = is_null($this->researchForm) ? "" : $this->getResearchForm()->count();
        }
        return $this->_data['researchFormCount'];
    }

    /**
     * @return html roles for roles column in admin index
     */
    public function getRolesHTML() {
        $query = new Query;
        $query->select('item_name')
                ->from('{{%auth_assignment}}')
                ->where('user_id=' . $this->id);
        $command = $query->createCommand();
        $roles = $command->queryAll();

        return $roles;
    }

    public function beforeDelete() {
        if (Yii::$app->authManager->revokeAll($this->id)) {
            $this->unlinkAll('profile', true);
        }
        return parent::beforeDelete();
    }

}
