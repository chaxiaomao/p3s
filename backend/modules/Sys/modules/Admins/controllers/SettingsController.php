<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\modules\Sys\modules\Admins\controllers;

use dektrium\user\controllers\SettingsController as BaseController;

/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends BaseController {

    /**
     * Shows profile settings form.
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile() {
        // Load Model
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        // If Profile not exist create it
        if ($model == null) {
            $model = \Yii::createObject(Profile::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        // Load Old Image
        $oldImage = $model->avatar;

        // Load avatarPath from Module Params
        $avatarPath = \Yii::getAlias($this->module->avatarPath);

        // Create uploadAvatar Instance
        $image = $model->uploadAvatar($avatarPath);

        // Profile Event
        $event = $this->getProfileEvent($model);

        // Ajax Validation
        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {

            // revert back if no valid file instance uploaded
            if ($image === false) {

                $model->avatar = $oldImage;
            } else {

                // if is there an old image, delete it
                if ($oldImage) {
                    $model->deleteImage($oldImage);
                }

                // upload new avatar
                $model->avatar = $image->name;
            }

            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));

            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);

            return $this->refresh();
        }

        return $this->render('profile', [
                    'model' => $model
        ]);
    }

}
