<?php

/**
 * Created by PhpStorm.
 * User: chenangel
 * Date: 2017/12/21
 * Time: 下午3:35
 */

namespace common\helpers;

use common\models\c2\statics\RegistrationSrcType;

class DeviceLogHelper {

    public static function log($data) {
//        \Yii::info(self::getDevice());
        \Yii::info($data, self::getDevice());
    }
    
    public static function getDevice() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (true == preg_match("/.+Windows.+/", $agent)) {
            return "debug";
        } elseif (true == preg_match("/.+Macintosh.+/", $agent)) {
            return "debug";
        } elseif (true == preg_match("/.+iPad.+/", $agent)) {
            return "ios";
        } elseif (true == preg_match("/.+iPhone.+/", $agent)) {
            return "ios";
        } elseif (true == preg_match("/.+Android.+/", $agent)) {
            \Yii::info('走了安卓日志','debug');
            return "android";
        } else {
            return "debug";
        }
    }

    public static function getDeviceType() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        // if (\Yii::$app->wechat->isWechat){
        //     return RegistrationSrcType::TYPE_WECHAT ;
        // }

        if (true == preg_match("/.+Windows.+/", $agent)) {
            return RegistrationSrcType::TYPE_WEB ;
        } elseif (true == preg_match("/.+Macintosh.+/", $agent)) {
            return RegistrationSrcType::TYPE_IOS ;
        } elseif (true == preg_match("/.+iPad.+/", $agent)) {
            return RegistrationSrcType::TYPE_IOS;
        } elseif (true == preg_match("/.+iPhone.+/", $agent)) {

            return RegistrationSrcType::TYPE_IOS;
        } elseif (true == preg_match("/.+Android.+/", $agent)) {
            \Yii::info('走了安卓日志','debug');

            return RegistrationSrcType::TYPE_ANDROID;
        } else {

            return RegistrationSrcType::TYPE_WECHAT ;
        }
    }

}
