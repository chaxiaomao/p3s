<?php

/**
 * Project: yii2-easyWeChat.
 * Author: Max.wen
 * Date: <2016/05/10 - 17:17>
 */

namespace common\components\Wechat;

use yii\base\Component;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;

/**
 * Class WechatUser
 * @package common\components
 *
 * @property string $openId
 */
class WechatUser extends Component {

    /**
     * @var array the attached event handlers (event name => handlers)
     */
    private $_events = [];

    /**
     * @var Behavior[]|null the attached behaviors (behavior name => behavior). This is `null` when not initialized.
     */
    private $_behaviors;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $nickname;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $avatar;

    /**
     * @var string
     */
    public $provider;

    /**
     * store new porperties which not existed yet
     * @var array
     */
    public $extraData = [];

    /**
     * @var array
     */
    public $original = [];

    /**
     * @var \Overtrue\Socialite\AccessToken
     */
    public $token;

    public function __set($name, $value) {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            // set property
            $this->$setter($value);

            return;
        } elseif (strncmp($name, 'on ', 3) === 0) {
            // on event: attach event handler
            $this->on(trim(substr($name, 3)), $value);

            return;
        } elseif (strncmp($name, 'as ', 3) === 0) {
            // as behavior: attach behavior
            $name = trim(substr($name, 3));
            $this->attachBehavior($name, $value instanceof Behavior ? $value : Yii::createObject($value));

            return;
        }

        // behavior property
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $behavior) {
            if ($behavior->canSetProperty($name)) {
                $behavior->$name = $value;
                return;
            }
        }

        if (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        }

        $this->extraData[$name] = $value;
        return;

//        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * @return string
     */
    public function getOpenId() {
        return isset($this->original['openid']) ? $this->original['openid'] : '';
    }

    public function getProperties() {
        return array_merge($this->original, $this->extraData);
    }

}
