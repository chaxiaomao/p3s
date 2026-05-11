<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/10
 * Time: 17:15
 */

namespace backend\controllers;


use common\models\c2\entity\Product;
use common\models\c2\statics\ProductType;
use cza\base\models\statics\EntityModelStatus;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{

    private $appKey = '65fe2ad655a91b8f61cb5d71d0157549';
    private $companyCode = 'EWBZSMTDSYXGS';
    private $sign = 'UISZ';

    public $result;

    public function actionProductSearch($keyword, $type = ProductType::TYPE_PRODUCT, $isCL = false)
    {
        $query = Product::find()->select('id,name,sku');

        $query->where([
            'type' => $type,
        ]);

        // if ($isCL) {
        //     $query->andWhere(['like', 'sku', 'cl-']);
        // }

        if (!empty($keyword)) {
            // $query->andWhere(['like', 'name', $keyword]);
            $query->andWhere([
                'or',
                ['like', 'sku', $keyword],
                ['like', 'name', $keyword],
            ]);
        }

        $query->andFilterWhere(['status' => EntityModelStatus::STATUS_ACTIVE]);

        $data = $query->asArray()->all();

        $items = [];

        foreach ($data as $datum) {
            $items[] = [
                'id' => $datum['id'],
                'text' => $datum['sku'] . '(' . $datum['name'] . ')',
            ];
        }

        return [
            'results' => $items,
        ];
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_HEADER, ['application/x-www-form-urlencoded;charset=utf-8']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); //设置请求方式
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

    public function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

}