<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/10
 * Time: 17:15
 */

namespace backend\controllers;


use linslin\yii2\curl\Curl;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{

    private $appKey = '65fe2ad655a91b8f61cb5d71d0157549';
    private $companyCode = 'EWBZSMTDSYXGS';
    private $sign = 'UISZ';

    public $result;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['apply'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://yp.atjy1.cn'],
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Expose-Header' => ['X-Pagination-Current-Page'],
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
        ];
    }

    public function actionApply()
    {
        return ['code' => '1'];
    }

    public function actionAssess()
    {
        $params = [
            'logisticCompanyID' => 'DEPPON',
            'originalsStreet' => '上海-上海市-长宁区',
            'originalsaddress' => '上海-上海市-长宁区',
            'sendDateTime' => '2018-08-07 11:00:03',
            'totalVolume' => '0.001',
            'totalWeight' => '500',
        ];
        $time = $this->getMillisecond();
        $plainText = json_encode($params, JSON_UNESCAPED_UNICODE) . $this->appKey . $time;
        $digest = $this->getDigest($plainText);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dpsanbox.deppon.com/sandbox-web/standard-order/queryPriceTime.action");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_HEADER, ['application/x-www-form-urlencoded;charset=utf-8']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'digest' => $digest,
            'timestamp' => $time,
            'companyCode' => $this->companyCode,
        ]);

        $returnStr = curl_exec($ch);
        curl_close($ch);
        var_dump($returnStr);
    }

    public function getDigest($plainText)
    {
        return base64_encode(md5($plainText));
    }

    public function actionTest()
    {
        $params = [
            'logisticCompanyID' => 'DEPPON',
            'originalsStreet' => '上海-上海市-长宁区',
            'originalsaddress' => '上海-上海市-长宁区',
            'sendDateTime' => '2018-08-07 11:00:03',
            'totalVolume' => '0.001',
            'totalWeight' => '500',
        ];
        // $json = '{"backSignBill":"0","businessNetworkNo":"W011302020515","cargoName":"干果","codType":"1","customerCode":"219402","customerID":"chanelUserA","deliveryType":"0","insuranceValue":3000,"logisticCompanyID":"DEPPON","orderSource":"EWBSHWL","logisticID":"AL353453129","serviceType":"1","payType":"0","gmtCommit":" 2012-11-27 18:44:19","receiver":{"address":"明珠路1018号","city":"上海市","county":"青浦区","mobile":"15800000000","name":"宝某某","phone":"","province":"上海"},"sender":{"address":"北京中路100号","city":"贵阳市","county":"花溪区","mobile":"15800000001","name":"淘某某","phone":"","province":"贵州省"},"smsNotify":"Y","toNetworkNo":"W01061502","totalNumber":500,"totalVolume":400,"totalWeight":300,"transportType":"PACKAGE","vistReceive":"Y"}';
        $time = $this->getMillisecond();
        $plainText = json_encode($params, JSON_UNESCAPED_UNICODE) . $this->appKey . $time;
        $digest = $this->getDigest($plainText);
        return $time . "\r\n" . $digest . "\r\n" . json_encode($params, JSON_UNESCAPED_UNICODE);
    }

    public function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

}