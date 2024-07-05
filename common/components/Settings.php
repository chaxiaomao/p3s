<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\caching\Cache;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii2mod\settings\models\enumerables\SettingType;
use cza\base\models\statics\ImageSize;

/**
 * Class Settings
 * modify from yii2mod\settings\components
 */
class Settings extends Component {

    protected $_data = [];  // caching on flying

    /**
     * @var string setting model class name
     */
    public $modelClass = 'common\models\c2\entity\Config';

    /**
     * @var Cache|array|string the cache used to improve RBAC performance. This can be one of the followings:
     *
     * - an application component ID (e.g. `cache`)
     * - a configuration array
     * - a [[yii\caching\Cache]] object
     *
     * When this is not set, it means caching is not enabled
     */
    public $cache = 'cache';

    /**
     * @var string the key used to store settings data in cache
     */
    public $cacheKey = 'cza-setting';

    /**
     * @var \yii2mod\settings\models\SettingModel setting model
     */
    protected $model;

    /**
     * @var array list of settings
     */
    protected $items = [];

    /**
     * @var mixed setting value
     */
    protected $setting;

    /**
     * Initialize the component
     */
    public function init() {
        parent::init();

        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, Cache::class);
        }

        $this->model = Yii::createObject($this->modelClass);
    }

    /**
     * Get's the value for the given section and key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        if (empty($this->items)) {
            $this->getAll();
        }
        if (isset($this->items[$key])) {
            $value = ArrayHelper::getValue($this->items[$key], 'value');
        } else {
            $value = $default;
        }

        return $value;
    }

    public function getImageUrl($code, $attribute = "", $format = ImageSize::ORGINAL) {
        $key = "{$code}_{$format}";
        if (is_null($this->get($key))) {
            $modelClass = $this->modelClass;
            $model = $modelClass::find()->where(['code' => $code])->active()->one();
            if (!is_null($model)) {
                $url = $model->getAttachmentImage($attribute)->getUrlByFormat($format);
                $this->set($key, $url);
            }
        }
        return $this->get($key);
    }

    /**
     * Checking existence of setting
     *
     * @param string $section
     * @param string $key
     *
     * @return bool
     */
    public function has($key) {
        $setting = $this->get($key);

        return !empty($setting);
    }

    /**
     * Returns the settings config
     *
     * @return array
     */
    public function getAll() {
        if (!$this->cache instanceof Cache) {
            $this->items = $this->model->getSettings();
        } else {
            $cacheItems = $this->cache->get($this->cacheKey);
            if (!empty($cacheItems)) {
                $this->items = $cacheItems;
            } else {
                $this->items = $this->model->getSettings();
                $this->cache->set($this->cacheKey, $this->items);
            }
        }

        return $this->items;
    }

    public function set($key, $val) {
        $this->items = $this->getAll();
        $this->items[$key] = ['value' => $val];

        $this->cache->set($this->cacheKey, $this->items);
    }

    public function deleteValue($key) {
        return $this->cache->delete($key);
    }

    /**
     * Invalidate the cache
     *
     * @return bool
     */
    public function cleanupCache($path = '') {
        if ($this->cache !== null) {
            if ($path != '') {
                $this->cache->cachePath = $path;
            }
            $this->cache->delete($this->cacheKey);
            $this->items = null;
        }

        return true;
    }

    public function getGeneralDistributor() {
        $key = $this->get('biz\general_distributor');
        if (!isset($this->_data[$key])) {
            $this->_data[$key] = \common\models\c2\entity\Distributor::findOne(['id' => $key]);
        }
        return $this->_data[$key];
    }

    public function getEshop() {
        if (isset($this->_data['eshop'])) {
            return $this->_data['eshop'];
        }
        if (isset(Yii::$app->params['config']['eshop']['code'])) {
            $this->_data['eshop'] = \common\models\c2\entity\Eshop::find(['code' => Yii::$app->params['config']['eshop']['code']])->active()->one();
            return $this->_data['eshop'];
        }
        return null;
    }

}
