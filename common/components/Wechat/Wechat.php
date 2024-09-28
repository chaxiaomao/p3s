<?php

/**
 * Project: yii2-easyWeChat.
 * Author: Max.wen
 * Date: <2016/05/10 - 14:31>
 */

namespace common\components\Wechat;

use Yii;
use EasyWeChat\Foundation\Application;
use maxwen\easywechat\Wechat as BaseModel;
use yii\base\Component;
use yii\helpers\Url;

/**
 * Class Wechat
 * @package common\components
 *
 * @property Application $app
 * @property WechatUser  $user
 * @property bool        $isWechat
 * @property string      $returnUrl
 */
class Wechat extends BaseModel {

    /**
     * @var Application
     */
    private static $_app;

    /**
     * @var WechatUser
     */
    private static $_user;

    /**
     * user identity class params
     * @var array
     */
    public $userOptions = [];

    /**
     * wechat user info will be stored in session under this key
     * @var string
     */
    public $sessionParam = '_wechatUser';

    /**
     * returnUrl param stored in session
     * @var string
     */
    public $returnUrlParam = '_wechatReturnUrl';
    public $returnRoute = '/authorize/wechat';
    public $agentReturnUrl = "";

    /**
     *
     * @param string/array $config
     * @return type
     */
    public function getApp($config = '') {
        if (!self::$_app instanceof Application) {
            $params = empty($config) ? Yii::$app->params['WECHAT'] : (is_string($config) ? Yii::$app->params[$config] : $config);
            self::$_app = new Application($params);
        }
        return self::$_app;
    }

    /**
     * @return yii\web\Response
     */
    public function authorizeRequired() {
        if (Yii::$app->request->get('code')) {
            // callback and authorize
//            Yii::info("authorizeRequired: " . Yii::$app->request->get(), 'debug');
            $this->authorize($this->app->oauth->user());
            return Yii::$app->response->redirect($this->getReturnUrl());
        } else {
            // redirect to wechat authorize page
            $returnUrl = empty($this->agentReturnUrl) ? Url::toRoute($this->returnRoute, true) : $this->agentReturnUrl;
            $returnUrl = $this->regular($returnUrl)?$this->regular($returnUrl):$returnUrl;
            $this->setReturnUrl($returnUrl);
            $targetUrl = $this->app->oauth->scopes(['snsapi_userinfo'])->redirect($returnUrl)->getTargetUrl();
            Yii::info('returnUrl:' . $returnUrl, 'debug');
            Yii::info('targetUrl:' . $targetUrl, 'debug');
            return Yii::$app->response->redirect($targetUrl);
        }
    }

    public function regular($returnURl){
        $start = strpos($returnURl,"?from")?strpos($returnURl,"?from"):strpos($returnURl,"?uid");
        $tmp = substr($returnURl,$start);
        if ($tmp){
            Yii::info('tmp:' . $tmp, 'debug');
            $returnUrl = str_replace($tmp,'',$returnURl);
            Yii::info('returnUrl:' . $returnURl, 'debug');
            return $returnUrl;
        }
        return false;
    }

    /**
     * @param \Overtrue\Socialite\User $user
     * @return yii\web\Response
     */
    public function authorize(\Overtrue\Socialite\User $user) {
        Yii::$app->session->set($this->sessionParam, $user->toJSON());
//        return Yii::$app->response->redirect($this->getReturnUrl());
    }

    /**
     * check if current user authorized
     * @return bool
     */
    public function isAuthorized() {
        $hasSession = Yii::$app->session->has($this->sessionParam);
        $sessionVal = Yii::$app->session->get($this->sessionParam);
        return ($hasSession && !empty($sessionVal));
    }

    /**
     * @param string|array $url
     */
    public function setReturnUrl($url) {
        Yii::$app->session->set($this->returnUrlParam, $url);
    }

    /**
     * @param null $defaultUrl
     * @return mixed|null|string
     */
    public function getReturnUrl($defaultUrl = null) {
        $url = Yii::$app->getSession()->get($this->returnUrlParam, $defaultUrl);
        if (is_array($url)) {
            if (isset($url[0])) {
                return Yii::$app->getUrlManager()->createUrl($url);
            } else {
                $url = null;
            }
        }

        return $url === null ? Yii::$app->getHomeUrl() : $url;
    }

    /**
     * @return WechatUser|null
     */
    public function getUser() {
        if (!$this->isAuthorized()) {
            return new WechatUser();
        }

        if (!self::$_user instanceof WechatUser) {
            $userInfo = Yii::$app->session->get($this->sessionParam);
            $config = $userInfo ? json_decode($userInfo, true) : [];
            self::$_user = new WechatUser($config);
        }
        return self::$_user;
    }

    /**
     * check if client is wechat
     * @return bool
     */
    public function getIsWechat() {
        return strpos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger") !== false;
    }

}
