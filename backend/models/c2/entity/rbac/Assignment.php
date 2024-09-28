<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace backend\models\c2\entity\rbac;

use dektrium\rbac\models\Assignment as BaseModel;
use yii\db\ActiveQuery;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Assignment extends BaseModel {

    /**
     * @inheritdoc
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find() {
        return \Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * Declares the name of the database table associated with this AR class.
     * By default this method returns the class name as the table name by calling [[Inflector::camel2id()]]
     * with prefix [[Connection::tablePrefix]]. For example if [[Connection::tablePrefix]] is 'tbl_',
     * 'Customer' becomes 'tbl_customer', and 'OrderItem' becomes 'tbl_order_item'. You may override this method
     * if the table is not named after this convention.
     * @return string the table name
     */
    public static function tableName() {
        return '{{%auth_assignment}}';
    }

    /**
     * Returns the database connection used by this AR class.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return \Yii::$app->getDb();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'items' => \Yii::t('app.c2', 'Items'),
        ];
    }

}
