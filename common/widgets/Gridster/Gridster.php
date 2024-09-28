<?php

namespace common\widgets\Gridster;

use Yii;
use cza\base\widgets\Widget;
use yii\base\InvalidCallException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;
use cza\base\models\statics\OperationEvent;
use yii\helpers\Url;
use yii\web\View;
use common\models\c2\statics\CmsBlockLayout;
use common\widgets\Gridster\GridsterAsset;

/**
 * Gridster Widget
 * Refer to https://github.com/stratoss/yii2-gridster
 * @author Ben Bi <bennybi@qq.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class Gridster extends Widget {

    /**
     * @var string the main container tag
     */
    public $tag = 'div';

    /**
     * @var array the HTML attributes for the widget sub container tag.
     */
    public $subOptions = [];

    /**
     * @var integer the layoutType which depend on class  cmsBlockLayout.
     */
    public $initType = null;
    public $definition = null;
    public $static = false;
    public $loadImage = null;

    /**
     * @var string the sub container tag
     */
    public $subTag = 'ul';

    /**
     * @var array the gridster widgets that are currently active
     */
    private $_widgets = [];

    public function init() {
        parent::init();
        $defaultOptions = [
        ];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);
        if (is_null($this->initType)) {
            $this->initType = CmsBlockLayout::TYPE_DEFAULT;
        }

//        if (empty($this->model)) {
//            throw new \yii\base\Exception('model parameter is required!');
//        }

        GridsterAsset::register($this->view);
    }

    /**
     * Generates a gridster start tag.
     * @param array $options
     * @param array $subOptions
     * @param string $tag
     * @param string $subTag
     * @return string the concatenated generated tags.
     * @see endContainer()
     */
    public static function beginContainer($options = [], $subOptions = [], $tag = 'div', $subTag = 'ul') {
        return Html::beginTag($tag, $options) . Html::beginTag($subTag, $subOptions);
    }

    /**
     * Generates a gridster end tag.
     * @param string $tag
     * @param string $subTag
     * @return string the concatenated generated tags.
     * @see beginContainer()
     */
    public static function endContainer($tag = 'div', $subTag = 'ul') {
        return Html::endTag($subTag) . Html::endTag($tag);
    }

    /**
     * Generates a gridster widget begin tag.
     * This method will create a new gridster widget and returns its opening tag.
     * You should call [[endWidget()]] afterwards.
     * @param array $options
     * @param string $tag
     * @return string the generated tag
     * @see endWidget()
     */
    public function beginWidget($options = [], $tag = 'li') {
        $widget = Html::beginTag($tag, $options);
        $this->_widgets[] = $widget;
        return $widget;
    }

    /**
     * Generates a gridster widget end tag.
     * @param string $tag
     * @return string the generated tag
     * @see beginWidget()
     */
    public function endWidget($tag = 'li') {
        $widget = array_pop($this->_widgets);
        if (!is_null($widget)) {
            return Html::endTag($tag);
        } else {
            throw new InvalidCallException('Mismatching endWidget() call.');
        }
    }

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the gridster close tag.
     * @throws InvalidCallException if `beginWidget()` and `endWidget()` calls are not matching
     */
    public function run() {
        echo self::beginContainer($this->options, $this->subOptions, $this->tag, $this->subTag);
        if (!empty($this->_widgets)) {
            throw new InvalidCallException('Each beginWidget() should have a matching endWidget() call.');
        }

         !$this->static ? $this->registerJs() : $this->regInitJs();
        echo self::endContainer($this->tag, $this->subTag);
    }

    public function regInitJs() {
        $id = $this->options['id'];
        $layoutDefinition = is_null($this->definition) ? CmsBlockLayout::getData($this->initType, 'defintion') : $this->definition;
        $loadImage = !is_null($this->loadImage) ? Json::encode($this->loadImage) : 'null';
        $view = $this->getView();
        $namespace = ["namespace" => "#$id"];
        $options = !empty($this->clientOptions) ? Json::encode(array_merge($namespace, $this->clientOptions)) : Json::encode($namespace);
        $toExtend = <<<EXTEND
{
      'serialize_params': function (\$w, wgd) {
          return {
              col: wgd.col,
              row: wgd.row,
              size_x: wgd.size_x,
              size_y: wgd.size_y
          }
      }
  }
EXTEND;
        $toWidgets = <<<WIDGETS
//    var {$id}_style="";
//    var {$id}_row=[];
//    var {$id}_col=[];

     $.each({$loadImage},function(index,item){
         var content = {$layoutDefinition}; 
         var imageUrl = item['image-url']==null? 'javascript:;' : item['image-url'];
         if(!content[index]){
          return false;          
        }
         var  gridli = gridster_{$id}.add_widget('<li class="static" style="vertical-align:middle;text-align:center;"></li>',content[index]['size_x'],content[index]['size_y'],content[index]['col'],content[index]['row']);
         gridli.append('<a href=\"'+imageUrl+'\" ><img src=\"'+item['image-src']+'\"  style=\"width:100%;height:100%;\" /></a>')
         gridli.css({
         'line-height':gridli.height()+'px',
         '*font-size':gridli.height()+'px',
          'zoom':1
        })
         
     })
     //gridster_{$id}.add_style_tag({$id}_style);
WIDGETS;
        $view->registerJs("var gridster_$id = jQuery('#$id $this->subTag').gridster($.extend($options,$toExtend)).data('gridster');\n ");
        $view->registerCss("* {margin:0;padding:0;}   .gridster a{margin:0 !important;}   .gridster li a{ float:none; max-height:100% !important;} .gridster li img{ object-fit:contain;}    ");
        $view->registerJs($toWidgets);
   
    }

    public function registerJs() {
        $id = $this->options['id'];
        $layoutTypeArr = Json::encode(CmsBlockLayout::getHashMap('id', 'defintion'));
        $layoutDefinition = is_null($this->definition) ? CmsBlockLayout::getData($this->initType, 'defintion') : $this->definition;
        $static = $this->static ? 'static' : '';
        $loadImage = !is_null($this->loadImage) ? Json::encode($this->loadImage) : 'null';


        $view = $this->getView();
        $namespace = ["el" => "#$id"];
        $options = !empty($this->clientOptions) ? Json::encode(array_merge($namespace, $this->clientOptions)) : Json::encode($namespace);
        $toExtend = <<<EXTEND
{
      'serialize_params': function (\$w, wgd) {
          return {
              /* add element ID to data*/
              //id: \$w.attr('id'),
              //html:\$w.html(),
              /* defaults */
              col: wgd.col,
              row: wgd.row,
              size_x: wgd.size_x,
              size_y: wgd.size_y
          }
      }
  }
EXTEND;
        $toWidgets = <<<WIDGETS
    var layoutDefinition ={$layoutDefinition};
    var layoutTypeArr = {$layoutTypeArr};
    var loadImage = {$loadImage};
    
     function renderwidget(id) {
      var content = layoutDefinition;
        if(id !== undefined){
           content =JSON.parse(layoutTypeArr[id]);
         }
        gridster.remove_all_widgets();
        $.each(content, function (index,item) {
          var size = getSize(item['size_x'],item['size_y']);
          var  widget = gridster.add_widget('<li class="{$static}">'+index+'<p class="block-size"><span>'+size[0]+'</span> * <span>'+size[1]+'</span></p></li>',item['size_x'], item['size_y'],item['col'],item['row']);
        });
    }
        function  getSize(x,y){
           var baseWidth =  (375 - 20 - 3 - (12+1) * 5)/ 12 ;
           var width = Math.round(baseWidth * x + (x-1)*5);
          // var height =Math.round(width*(y/x));
          var height =  Math.round(30 * y + (y-1)*5);
           return [width,height];
        }
    function loadImgs(){

    // gridster.remove_all_widgets();
     $.each(loadImage,function(index,item){
         var content = Gridster.sort_by_row_and_col_asc(layoutDefinition); 
         var  gridli = gridster.add_widget('<li class="{$static}"></li>',content[index]['size_x'],content[index]['size_y'],content[index]['col'],content[index]['row']);
         gridli.append('<img src=\"'+item['image-src']+'\" width=\"100%\"  height=\"100%\" />')  
     })  
   
   }    
WIDGETS;
         
        $view->registerJs("gridster = jQuery('#$id $this->subTag').gridster($.extend($options,$toExtend)).data('gridster');\n ");
        $view->registerJs($loadImage != "null" ? "loadImgs()" : "renderwidget()");
        $view->registerCss(".block-size{color:white;} ");
        $view->registerJs($toWidgets, View::POS_BEGIN);
    }

    /**
     * test js
     */
//    public function registerJs() {
//        
//    
//        
//        $js = "";
//        $js .= "var gridster;
//
//    $(function () {
//
//        gridster = $('.gridster > ul').gridster({
//            widget_margins: [5, 5],
//            widget_base_dimensions: [100, 55],
//            resize:{enabled:true}
//        }).data('gridster');
//
//        var widgets = [
//            ['<li>0</li>', 1, 2],
//            ['<li>1</li>', 3, 2],
//            ['<li>2</li>', 3, 2],
//            ['<li>3</li>', 2, 1],
//            ['<li>4</li>', 4, 1],
//            ['<li>5</li>', 1, 2],
//            ['<li>6</li>', 2, 1],
//            ['<li>7</li>', 3, 2],
//            ['<li>8</li>', 1, 1],
//            ['<li>9</li>', 2, 2],
//            ['<li>10</li>', 1, 3]
//        ];
//
//        $.each(widgets, function (i, widget) {
//            gridster.add_widget.apply(gridster, widget)
//        });
//
//    });\n";
//        $this->getView()->registerJs($js, View::POS_READY);
//    }
}
