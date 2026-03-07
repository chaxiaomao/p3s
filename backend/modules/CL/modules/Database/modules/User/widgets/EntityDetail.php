<?php

namespace backend\modules\CL\modules\Database\modules\User\widgets;

use backend\models\c2\entity\FeUserProfileForm;
use common\models\c2\entity\FeUserProfile;
use Yii;
use cza\base\widgets\ui\common\part\EntityDetail as DetailWidget;

/**
 * Entity Detail Widget
 *
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class EntityDetail extends DetailWidget
{
    public $withTranslationTabs = false;

    public $withProfileTab = false;

    public function getTabItems() {
        $items = [];

        if ($this->withTranslationTabs) {
            $items[] = $this->getTranslationTabItems();
        }

        if ($this->withProfileTab) {
            $items[] = $this->getProfileTab();
        }

        if ($this->withBaseInfoTab) {
            $items[] = [
                'label' => Yii::t('app.c2', 'Base Information'),
                'content' => $this->controller->renderPartial('_form', [ 'model' => $this->model,]),
                'active' => true,
            ];
        }

        $items[] = [
            'label' => '<i class="fa fa-th"></i> ' . $this->tabTitle,
            'onlyLabel' => true,
            'headerOptions' => [
                'class' => 'pull-left header',
            ],
        ];

        return $items;
    }

    public function getProfileTab()
    {
        if (!isset($this->_tabs['PROFILE_TAB'])) {
            if (!$this->model->isNewRecord) {
                $model = $this->model->profile;
                if (is_null($model)) {
                    $model = new FeUserProfile();
                }
                $this->_tabs['PROFILE_TAB'] = [
                    'label' => Yii::t('app.c2', 'Profile'),
                    'content' => $this->controller->renderPartial('_profile_form', ['model' => $model, 'entityModel' => $this->model]),
                    'enable' => true,
                ];
            } else {
                $this->_tabs['PROFILE_TAB'] = [
                    'label' => Yii::t('app.c2', 'Profile'),
                    'content' => "",
                    'enable' => false,
                ];
            }
        }

        return $this->_tabs['PROFILE_TAB'];
    }

}