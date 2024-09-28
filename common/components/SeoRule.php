<?php
/**
 * Created by PhpStorm.
 * User: chenangel
 * Date: 2017/8/23
 * Time: 上午9:37
 */

namespace common\components;


use cza\base\models\statics\EntityModelStatus;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;
use SuperClosure\Serializer;
use yii\helpers\Json;

class SeoRule implements UrlRuleInterface
{

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
//        \Yii::info('\n');
//        \Yii::info('parseRequest-$request');
//        \Yii::info($request);
//        \Yii::info('\n');
        $pathInfo = $request->getPathInfo();
        $rules = $this->getRules();
        foreach ($rules as $rule){
            if (preg_match($rule->preg_match, $pathInfo, $matches)) {
                if ($rule->preg_match_url === $matches[0]){
                    return [$rule->parse_url,Json::decode($rule->params,true)];
                }
                return false;
            }
        }
        return false;
    }

    public function getRules(){
        $data = \common\models\c2\entity\SeoRule::getDb()->cache(function($db){
            return \common\models\c2\entity\SeoRule::find(['status' => EntityModelStatus::STATUS_ACTIVE])->all();
        },60*60);
        return $data;

    }


    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|bool the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
//        \Yii::info('createUrl-$manager');
//        \Yii::info($manager);
//        \Yii::info('\n');
//        \Yii::info('createUrl-$route');
//        \Yii::info($route);
//        \Yii::info('\n');
//        \Yii::info('createUrl-$params');
//        \Yii::info($params);
//        \Yii::info('\n');
        return false;

    }
}