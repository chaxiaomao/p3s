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

use dektrium\rbac\models\Role as BaseModel;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Role extends BaseModel
{
    public function attributeLabels() {
        return [
            'name' => \Yii::t('app.c2', 'Item Name'),
            'description' => \Yii::t('app.c2', 'Description'),
            'children' => \Yii::t('app.c2', 'Subitems'),
            'rule' => \Yii::t('app.c2', 'Rule'),
            'data' => \Yii::t('app.c2', 'Data'),
        ];
    }
}