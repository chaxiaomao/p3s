<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 10:24
 */

namespace common\components\Sms;

use Yii;

class WxtSms2 extends \yii\base\Component{
    const STATE_SUCCESS = 'Success';
    const STATE_FAILED = 'Faild';

    /**
     *
     * @var string
     */
    //public $url = "http://client.movek.net:8888/sms.aspx?action=send";
      public $url = "http://sms.wxtmx.net/sms.aspx?action=send";
    /**
     *
     * @var string
     */
    protected $_userid;
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

    /**
     * send _message
     *
     * @param string $mobile
     * @param string $content
     * @return boolean
     */
    public function send($mobile, $content, $sendtime = "") {
        $data = [
            'userid' => $this->userid,
            'account' => $this->account,
            'password' => $this->password,
            'mobile' => $mobile,
            'content' => $content,
            'sendtime' => $sendtime,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $returnStr = curl_exec($ch);
        curl_close($ch);
//        Yii::info($returnStr);
        $this->_result = simplexml_load_string($returnStr);
//        Yii::info($this->_result);

        if ($this->_result && $this->_result instanceof \SimpleXMLElement) {
            $this->_state = $this->_result->returnstatus;
            $this->_message = $this->_result->message;
            if ($this->_state == static::STATE_SUCCESS) {
                return true;
            }
        }

        return false;
    }

    public function setAccount($val) {
        $this->_account = $val;
    }

    public function setUserid($val) {
        $this->_userid = $val;
    }

    public function setPassword($val) {
        $this->_password = $val;
    }

    public function getAccount() {
        return $this->_account;
    }

    public function getUserid() {
        return $this->_userid;
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