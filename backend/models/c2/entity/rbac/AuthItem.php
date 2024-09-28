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

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\helpers\Json;
use yii\rbac\Item;
use dektrium\rbac\validators\RbacValidator;
use dektrium\rbac\models\AuthItem as BaseModel;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
abstract class AuthItem extends BaseModel {

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => \Yii::t('app.c2', 'Item Name'),
            'description' => \Yii::t('app.c2', 'Description'),
            'children' => \Yii::t('app.c2', 'Subitems'),
            'rule' => \Yii::t('app.c2', 'Rule'),
            'data' => \Yii::t('app.c2', 'Data'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['name', 'required'],
            [['name', 'description', 'rule'], 'trim'],
            ['name', function () {
                    if ($this->manager->getItem($this->name) !== null) {
                        $this->addError('name', \Yii::t('app.c2', 'Auth item with such name already exists'));
                    }
                }, 'when' => function () {
                    return $this->scenario == 'create' || $this->item->name != $this->name;
                }],
            ['children', RbacValidator::className()],
            ['rule', function () {
                    $rule = $this->manager->getRule($this->rule);

                    if (!$rule) {
                        $this->addError('rule', \Yii::t('app.c2', 'Rule {0} does not exist', $this->rule));
                    }
                }],
            ['data', function () {
                    try {
                        Json::decode($this->data);
                    } catch (InvalidParamException $e) {
                        $this->addError('data', \Yii::t('app.c2', 'Data must be type of JSON ({0})', $e->getMessage()));
                    }
                }],
        ];
    }

    /**
     * Saves item.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate() == false) {
            return false;
        }

        if ($isNewItem = ($this->item === null)) {
            $this->item = $this->createItem($this->name);
        } else {
            $oldName = $this->item->name;
        }

        $this->item->name = $this->name;
        $this->item->description = $this->description;
        $this->item->data = $this->data == null ? null : Json::decode($this->data);
        $this->item->ruleName = empty($this->rule) ? null : $this->rule;

        if ($isNewItem) {
            \Yii::$app->session->setFlash('success', \Yii::t('app.c2', 'Saved successful.'));
            $this->manager->add($this->item);
        } else {
            \Yii::$app->session->setFlash('success', \Yii::t('app.c2', 'Saved successful.'));
            $this->manager->update($oldName, $this->item);
        }

        $this->updateChildren();

        $this->manager->invalidateCache();

        return true;
    }

}
