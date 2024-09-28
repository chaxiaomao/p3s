<?php

namespace common\models\c2\statics;

use Yii;

/**
 * Image different sizes definition
 *
 * @author ben
 */
class EshopImageSize
{

    const ICON = 'i';
    const THUMBNAIL = 't';
    //    const SMALL = 's';
    const MEDIUM = 'm';
    const ORGINAL = 'o';

    protected static $_data = [
        self::ICON => ['width' => 32, 'height' => 32],
        self::THUMBNAIL => ['width' => 186, 'height' => 186],
        //        self::SMALL => ['width' => 86, 'height' => 54],
        self::MEDIUM => ['width' => 270, 'height' => 270],
        self::ORGINAL => ['width' => -1, 'height' => -1],
    ];

    public static function getIds()
    {
        return array_keys(self::$_data);
    }

    public static function getSize($size)
    {
        return self::$_data[$size];
    }

    public static function getHeight($size)
    {
        return self::$_data[$size]['height'];
    }

    public static function getWidth($size)
    {
        return self::$_data[$size]['width'];
    }

}
