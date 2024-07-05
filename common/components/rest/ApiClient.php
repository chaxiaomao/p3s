<?php

/**
 * ApiClient
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

abstract class ApiClient extends Component {

    protected $_data = [];
    
    public static $PATCH = "PATCH";
    public static $POST = "POST";
    public static $GET = "GET";
    public static $HEAD = "HEAD";
    public static $OPTIONS = "OPTIONS";
    public static $PUT = "PUT";
    public static $DELETE = "DELETE";

    /**
     * Configuration
     *
     * @var Configuration
     */
    public $config;
    
    public $algorithm  = 'sha256';

    /**
     * Object Serializer
     *
     * @var ObjectSerializer
     */
    public $serializer;

    public function __construct($config = []) {
        if (!empty($config['config'])) {
            $this->setConfig($config['config']);
            unset($config['config']);
        }
        if (!empty($config['serializer'])) {
            $this->setSerializer($config['serializer']);
            unset($config['serializer']);
        }
        parent::__construct($config);
    }

    public function setConfig($v) {
        $this->config = Yii::createObject($v);
    }

    /**
     * Get the config
     *
     * @return Configuration
     */
    public function getConfig() {
        return $this->config;
    }

    public function setSerializer($v) {
        $this->serializer = Yii::createObject($v);
    }

    /**
     * Get the serializer
     *
     * @return ObjectSerializer
     */
    public function getSerializer() {
        return $this->serializer;
    }

    /**
     * Get API key (with prefix if set)
     *
     * @param  string $apiKeyIdentifier name of apikey
     *
     * @return string API key with the prefix
     */
    public function getApiKeyWithPrefix($apiKeyIdentifier) {
        $prefix = $this->config->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->config->getApiKey($apiKeyIdentifier);

        if (!isset($apiKey)) {
            return null;
        }

        if (isset($prefix)) {
            $keyWithPrefix = $prefix . " " . $apiKey;
        } else {
            $keyWithPrefix = $apiKey;
        }

        return $keyWithPrefix;
    }

    /**
     * 
     * @param type $endpoint
     * @param type $params
     * @return result array, for example:
     * [
      'error' => false,
      'code' => 400,
      'data' => $data,
      ]
     */
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

            return new ApiResult(['error' => false, 'code' => $statusCode, 'data' => $this->getSerializer()->deserialize($response, $config['toClass'], $httpHeader)]);
        } catch (ApiException $e) {
            $data = '';
            switch ($e->getCode()) {
                case 400:
                    $data = $e->getMessage();
                    break;
                case 401:
                    $newParams = $params;
                    Yii::info("previous access token: " . Yii::$app->user->getWfAccessToken() . ", refresh token: " . Yii::$app->user->getWfRefreshToken());
                    Yii::$app->user->refreshWfToken();
                    Yii::info("after access token: " . Yii::$app->user->getWfAccessToken() . ", refresh token: " . Yii::$app->user->getWfRefreshToken());
                    $newParams['headerParams']['Authorization'] = "Bearer " . Yii::$app->user->getWfAccessToken();
                    return $this->invoke($endpoint, $newParams);
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

    /**
     * invoke api with valid access token
     * @param type $endpoint
     * @param type $params
     */
    public function invokeWithToken($endpoint, $params = []) {
        $defaults = [
            'headerParams' => [
                'Authorization' => "Bearer " . Yii::$app->user->getWfAccessToken(),
            ],
        ];
        $config = ArrayHelper::merge($defaults, $params);

        return $this->invoke($endpoint, $config);
    }

    public function retrieveToken($params = []) {
        $config = [
            'httpBody' => ArrayHelper::merge([
                'grant_type' => 'password',
                'scope' => '*', //set to 'view_process' if not changing the process
                "client_id" => $this->config->getClientId(),
                "client_secret" => $this->config->getClientSecret(),
                    ], $params
            )
        ];

        return $this->invoke("/workflow/oauth2/token", $config);
    }

    public function refreshToken($params = []) {
        $config = [
            'httpBody' => ArrayHelper::merge([
                'grant_type' => 'refresh_token',
                "client_id" => $this->config->getClientId(),
                "client_secret" => $this->config->getClientSecret(),
                    ], $params
            )
        ];
        return $this->invoke("/workflow/oauth2/token", $config);
    }

    /**
     * Make the HTTP call (Sync)
     *
     * @param string $resourcePath path to method endpoint
     * @param string $method       method to call
     * @param array  $queryParams  parameters to be place in query URL
     * @param array  $postData     parameters to be placed in POST body
     * @param array  $headerParams parameters to be place in request header
     * @param string $responseType expected response type of the endpoint
     * @param string $endpointPath path to method endpoint before expanding parameters
     *
     * @throws \ProcessMaker\PMIO\ApiException on a non 2xx response
     * @return mixed
     */
    public function callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType = null, $endpointPath = null) {

        $headers = array();

        // construct the http header
        $headerParams = array_merge(
                (array) $this->config->getDefaultHeaders(), (array) $headerParams
        );

        foreach ($headerParams as $key => $val) {
            $headers[] = "$key: $val";
        }

        // form data
        if ($postData and in_array('Content-Type: application/x-www-form-urlencoded', $headers)) {
            $postData = http_build_query($postData);
        } elseif ((is_object($postData) or is_array($postData)) and ! in_array('Content-Type: multipart/form-data', $headers)) { // json model
            $postData = json_encode(\ProcessMaker\PMIO\ObjectSerializer::sanitizeForSerialization($postData));
        }

        $url = $this->config->getHost() . $resourcePath;

        $curl = curl_init();
        // set timeout, if needed
        if ($this->config->getCurlTimeout() != 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->config->getCurlTimeout());
        }
        // return the result on success, rather than just true
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // disable SSL verification, if needed
        if ($this->config->getSSLVerification() == false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        }

        if (!empty($queryParams)) {
            $url = ($url . '?' . http_build_query($queryParams));
        }

        if ($method == self::$POST) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method == self::$HEAD) {
            curl_setopt($curl, CURLOPT_NOBODY, true);
        } elseif ($method == self::$OPTIONS) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "OPTIONS");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method == self::$PATCH) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method == self::$PUT) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method == self::$DELETE) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method != self::$GET) {
            throw new ApiException('Method ' . $method . ' is not recognized.');
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        // Set user agent
        curl_setopt($curl, CURLOPT_USERAGENT, $this->config->getUserAgent());

        // debugging for curl
        if ($this->config->getDebug()) {
//            Yii::info("[DEBUG] HTTP Request body  ~BEGIN~" . PHP_EOL . print_r($postData, true) . PHP_EOL . "~END~" . PHP_EOL);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
        } else {
            curl_setopt($curl, CURLOPT_VERBOSE, 0);
        }

        // obtain the HTTP response headers
        curl_setopt($curl, CURLOPT_HEADER, 1);

        // Make the request
        $response = curl_exec($curl);
        $http_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $http_header = $this->httpParseHeaders(substr($response, 0, $http_header_size));
        $http_body = substr($response, $http_header_size);
        $response_info = curl_getinfo($curl);

        // debug HTTP response body
        if ($this->config->getDebug()) {
//            Yii::info("[DEBUG] HTTP Response body ~BEGIN~" . PHP_EOL . print_r($http_body, true) . PHP_EOL . "~END~" . PHP_EOL);
        }

        // Handle the response
        if ($response_info['http_code'] == 0) {
            $curl_error_message = curl_error($curl);

            // curl_exec can sometimes fail but still return a blank message from curl_error().
            if (!empty($curl_error_message)) {
                $error_message = "API call to $url failed: $curl_error_message";
            } else {
                $error_message = "API call to $url failed, but for an unknown reason. " .
                        "This could happen if you are disconnected from the network.";
            }

            $exception = new ApiException($error_message, 0, null, null);
            $exception->setResponseObject($response_info);
            throw $exception;
        } elseif ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299) {
            // return raw body if response is a file
            if ($responseType == '\SplFileObject' || $responseType == 'string') {
                return array($http_body, $response_info['http_code'], $http_header);
            }

            $data = json_decode($http_body);
            if (json_last_error() > 0) { // if response is a string
                $data = $http_body;
            }
        } else {
            $data = json_decode($http_body);
            if (json_last_error() > 0) { // if response is a string
                $data = $http_body;
            }

            throw new ApiException(
            "[" . $response_info['http_code'] . "] Error connecting to the API ($url)", $response_info['http_code'], $http_header, $data
            );
        }
        return array($data, $response_info['http_code'], $http_header);
    }

    /**
     * Return the header 'Accept' based on an array of Accept provided
     *
     * @param string[] $accept Array of header
     *
     * @return string Accept (e.g. application/json)
     */
    public function selectHeaderAccept($accept) {
        if (count($accept) === 0 or ( count($accept) === 1 and $accept[0] === '')) {
            return null;
        } elseif (preg_grep("/application\/json/i", $accept)) {
            return 'application/json';
        } else {
            return implode(',', $accept);
        }
    }

    /**
     * Return the content type based on an array of content-type provided
     *
     * @param string[] $content_type Array fo content-type
     *
     * @return string Content-Type (e.g. application/json)
     */
    public function selectHeaderContentType($content_type) {
        if (count($content_type) === 0 or ( count($content_type) === 1 and $content_type[0] === '')) {
            return 'application/json';
        } elseif (preg_grep("/application\/json/i", $content_type)) {
            return 'application/json';
        } else {
            return implode(',', $content_type);
        }
    }

    /**
     * Return an array of HTTP response headers
     *
     * @param string $raw_headers A string of raw HTTP response headers
     *
     * @return string[] Array of HTTP response heaers
     */
    protected function httpParseHeaders($raw_headers) {
        // ref/credit: http://php.net/manual/en/function.http-parse-headers.php#112986
        $headers = array();
        $key = '';

        foreach (explode("\n", $raw_headers) as $h) {
            $h = explode(':', $h, 2);

            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } elseif (is_array($headers[$h[0]])) {
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
                } else {
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
                }

                $key = $h[0];
            } else {
                if (substr($h[0], 0, 1) == "\t") {
                    $headers[$key] .= "\r\n\t" . trim($h[0]);
                } elseif (!$key) {
                    $headers[0] = trim($h[0]);
                }
                trim($h[0]);
            }
        }

        return $headers;
    }

}
