<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;

use Yii;
use yii\web\User as BaseUser;

/**
 * User is the class for the `user` application component that manages the user authentication status.
 *
 * @author Ben bi <bennybi@qq.com>
 */
class User extends BaseUser {

    private $_attributes = [];
    
    protected $_eshop = null;

    public $loginUrl = ['user/login'];

    public function getUsername() {

        if (!isset($this->_attributes['username'])) {
            $this->_attributes['username'] = $this->getIdentity() ? $this->getIdentity()->username: '';
        }
        return $this->_attributes['username'];
    }
    
//    public function 
//    
//    public function getCurrentEshopId(){
//        
//    }

    public function getAvatarUrl() {

        if (!isset($this->_attributes['avatarUrl'])) {
            $this->_attributes['avatarUrl'] = $this->getIdentity() ? $this->getIdentity()->profile->getImageUrl() : '';
        }
        return $this->_attributes['avatarUrl'];
    }

    public function getFullname() {
        if (!isset($this->_attributes['fullname'])) {
            $this->_attributes['fullname'] = $this->getIdentity() ? $this->getIdentity()->profile->getFullname() : '';
        }
        return $this->_attributes['fullname'];
    }

    public function getCurrentUser() {
        return $this->getIdentity();
    }

}
