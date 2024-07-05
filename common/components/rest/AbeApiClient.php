<?php

/**
 * 农行e管家访问客户端
 * Abc Bank's Ebiz ApiClient
 *
 * access api server
 *
 * @category Class
 * @package  common\components\rest
 * @author   ben <bennybi@qq.com>
 */

namespace common\components\rest;

use Yii;
use yii\base\Component;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use common\components\rest\ObjectSerializer;
use common\components\rest\ApiException;

class AbeApiClient extends ApiClient {

    public function retrieveToken($params = []) {
        $config = [
            'headerParams' => [
                'X-TimeStamp' => time(),
            ],
            'httpBody' => ArrayHelper::merge([
                'MerchantID' => $this->config->getMerchantId(),
                "SignFields" => $this->getSignFields(),
                "Signature" => $this->getSignature(),
                    ], $params
            )
        ];

        return $this->invoke("/Grant/AchieveToken", $config);
    }

    public function invoke($endpoint, $params = []) {
        // parse inputs
        $defaults = [
            'method' => ApiClient::$POST,
            'headerAccept' => ['application/json'],
            'headerParams' => [
                'Content-Type' => 'application/json',
            ],
            'formParams' => [],
            'queryParams' => [],
            'toClass' => 'object',
            'headerContentType' => ['application/json'],
            'httpBody' => [],
        ];

        $config = ArrayHelper::merge($defaults, $params);

//        if ($this->config->getDebug()) {
//            Yii::info("endpoint: " . $endpoint);
//            Yii::info($config);
//        }
        // make the API Call
        try {

            if (empty($endpoint)) {
                throw new ApiException(Yii::t("app.c2", "Endpoint is empty!"), 400);
            }

            list($response, $statusCode, $httpHeader) = $this->callApi(
                    $endpoint, $config['method'], $config['queryParams'], $config['httpBody'], $config['headerParams'], null, $endpoint
            );
            
            Yii::info($response);
            Yii::info($statusCode);
            Yii::info($httpHeader);

//            return new ApiResult(['error' => false, 'code' => $statusCode, 'data' => $this->getSerializer()->deserialize($response, $config['toClass'], $httpHeader)]);
        } catch (ApiException $e) {
            $data = '';
            switch ($e->getCode()) {
                case 400:
                    $data = $e->getMessage();
                    break;
                case 401:
//                    $newParams = $params;
//                    Yii::info("previous access token: " . Yii::$app->user->getWfAccessToken() . ", refresh token: " . Yii::$app->user->getWfRefreshToken());
//                    Yii::$app->user->refreshWfToken();
//                    Yii::info("after access token: " . Yii::$app->user->getWfAccessToken() . ", refresh token: " . Yii::$app->user->getWfRefreshToken());
//                    $newParams['headerParams']['Authorization'] = "Bearer " . Yii::$app->user->getWfAccessToken();
//                    return $this->invoke($endpoint, $newParams);
                case 200:
                    $data = $this->getSerializer()->deserialize($e->getResponseBody(), $config['toClass'], $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                    ;
                case 404:
                    $data = $this->getSerializer()->deserialize($e->getResponseBody(), $config['toClass'], $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->getSerializer()->deserialize($e->getResponseBody(), $config['toClass'], $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }
            return new ApiResult(['error' => true, 'code' => $e->getCode(), 'data' => $data]);
        }
    }

    public function getSignFields() {
        if (!isset($this->_data['SignFields'])) {
            $this->_data['SignFields'] = base64_encode($this->config->getClientId());
        }
        return $this->_data['SignFields'];
    }

    public function getSignature() {
        if (!isset($this->_data['Signature'])) {
            $this->_data['Signature'] = hash_hmac($this->algorithm, $this->data, $this->config->getClientSecret(), false);;
        }
        return $this->_data['Signature'];
    }

}
