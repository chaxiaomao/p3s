<?php

namespace common\components\Sms;

use Yii;

/**
 * AxSms - 爱讯 短信服务
 * Refer to daixianceng\smser (https://github.com/daixianceng/yii2-smser)
 * @author Ben Bi <jianbinbi@gmail.com>
 */
class AxSms extends \yii\base\Component {

    const STATE_SUCCESS = 'Success';
    const STATE_FAILED = 'Faild';

    /**
     *
     * @var string
     */
    public $url = "http://120.55.248.18/smsSend.do";  // 正式
//    public $url = "http://121.41.16.92/smsSend.do";  // 测试
    protected $_account;

    /**
     *
     * @var string
     */
    protected $_password;

    /**
     *
     * @var string
     */
    protected $_state;

    /**
     * @var string
     */
    protected $_message;
    protected $_result;
    protected $_encodedPwd = null;

    /**
     * send _message
     *
     * @param string $mobile  
     * @param string $content 
     * @return boolean        
     */
    public function send($mobile, $content, $sendtime = "") {
        $data = [
            'username' => $this->account,
            'password' => $this->getEncodedPwd(),
            'mobile' => $mobile,
            'content' => $content,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $this->_result = curl_exec($ch);
        curl_close($ch);

        //Yii::info($this->_result);
        return ($this->_result > 0);
    }

    public function getEncodedPwd() {
        if (is_null($this->_encodedPwd)) {
            $this->_encodedPwd = md5($this->getAccount() . md5($this->getPassword()));
        }
        return $this->_encodedPwd;
    }

    public function setAccount($val) {
        $this->_account = $val;
    }

    public function setPassword($val) {
        $this->_password = $val;
    }

    public function getAccount() {
        return $this->_account;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getState() {
        return $this->_state;
    }

    public function getMessage() {
        return $this->_message;
    }

    public function getResult() {
        return $this->_result;
    }

}
