<?php

namespace common\widgets\WeChat\PhotosUploader;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;
use cza\base\models\statics\OperationEvent;
use yii\helpers\Url;
use yii\web\View;
use common\assets\JqueryWeui\JqueryWeuiAsset;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use cza\base\models\statics\OperationResult;

/**
 *  PhotosUploader Widget
 * @author Ben Bi <bennybi@qq.com>
 * @license
 */
class PhotosUploader extends Widget {

    public $model = null;
    public $code = 'wx_album';
    public $dataProvider = null;
    public $itemTpl = '<li class="weui-uploader__file" style="background-image:url(#url#)" id="#hash#", data-hash="#hash#"></li>';
    public $uploadAction = 'images-upload';
    public $deleteAction = 'images-delete';
    public $pageSize = 8;
    public $uiOptions = [];

    public function init() {
        parent::init();
        $defaultOptions = $this->getDefaultOptions();
        $this->uiOptions = ArrayHelper::merge($defaultOptions, $this->uiOptions);

        if (empty($this->model)) {
            throw new \yii\base\Exception('model parameter is required!');
        }

        JqueryWeuiAsset::register($this->view);
    }
    
    public function getDefaultOptions(){
        return [
            'title' => Yii::t('app.c2', 'Images Upload'),
            'galleryId' => 'gallery',
            'galleryImgId' => 'galleryImg',
            'uploaderFilesId' => 'uploaderFiles',
            'uploaderInputId' => 'uploaderInput',
            'enableUpload' => true,
            'photoHandleCount' => 1, // 默认9，这里每次只处理一张照片
            'sizeType' => ["original", "compressed"], // 可以指定是原图还是压缩图，默认二者都有
        ];
    }

    public function run() {
//            OperationEvent::DELETE_BY_ID => "function(e, params){
//                e.preventDefault();
//                $.ajax({url:'" . Url::toRoute($this->deleteAction) . "',data:params}).done(function(result){
//                    $('#{$this->model->getPrefixName('images-list-pjax')} a.refresh').click();
//                }).fail(function(result){alert(result);});
//            } ",
//            OperationEvent::SORT => "function(e, params){
//                e.preventDefault();
//                $.ajax({url:'" . Url::toRoute($this->sortAction) . "',data:params}).done(function(result){}).fail(function(result){alert(result);});
//            } ",
//        ];

        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->model->getAttachmentImages($this->code),
            'pagination' => [
                'pageSize' => $this->pageSize,
                'params' => Yii::$app->request->get(),
            ],
        ]);


        $items = $this->dataProvider->getModels();

        $this->registerClientEvents();
        $this->registerJs();
        return $this->render($this->template, ['items' => $items,]);
    }

    public function registerJs() {
        $js = "";

        $js .= "wx.ready(function () {\n";

        $js .= "var currentHash = '';\n";
        $js .= 'var tmpl = \'' . $this->itemTpl . '\',
        $gallery = $("#' . $this->uiOptions['galleryId'] . '"), 
        $galleryImg = $("#' . $this->uiOptions['galleryImgId'] . '"),
        $uploaderInput = $("#' . $this->uiOptions['uploaderInputId'] . '"),
        $uploaderFiles = $("#' . $this->uiOptions['uploaderFilesId'] . '");';

        if ($this->uiOptions['enableUpload']) {
            $js .= $this->getTakePhotoJs();
        }
        
        $js .= '$uploaderFiles.on("click", "li", function (e) {
                    currentHash = $(this).data("hash");
//                    alert(currentHash); 
                    $galleryImg.attr("style", this.getAttribute("style"));
                    $gallery.fadeIn(100);
                });
                
                $gallery.on("click", function (e) {
                    $gallery.fadeOut(100);
                });
            ';

        //$js .= "wx.error(function (res) {
        //    alert(res.errMsg);
        //});";

        $js .= "\n";
        $js .= " });\n";  // end wx.ready

        $this->getView()->registerJs($js, View::POS_READY);
    }

    public function getTakePhotoJs() {
        $js = "";

        $js .= '// 图片接口
    
        // 拍照、本地选图
        var images = {
            localId: [],
            serverId: []
        }; 


        // 拍照或者选择照片
        function take_a_photo(){
            wx.chooseImage({
                count: ' . $this->uiOptions['photoHandleCount'] . ', // 默认9，这里每次只处理一张照片
                sizeType: ' . Json::encode($this->uiOptions['sizeType']) . ',   // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ["album", "camera"],        // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    images.localId = res.localIds;      // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    var i = 0, length = images.localId.length; 
                    function upload() {
                        wx.uploadImage({ 
                            localId: images.localId[i], 
                            success: function(res) {
//                                alert(JSON.stringify(images.localId[i])); 
//                                $uploaderFiles.append($(tmpl.replace(\'#url#\', images.localId[i])));
                               
                                images.serverId.push(res.serverId);

                                // res.serverId 就是 media_id，根据它去微信服务器读取图片数据：
                                var indata = {"media_id":res.serverId, "entity_id":"' . $this->model->id . '",};
//                                alert(JSON.stringify(indata));
                                $.post("' . $this->uploadAction . '", indata, function(data){
                                    if(data._meta.result == "' . OperationResult::ERROR . '"){
                                        alert(data._meta.message);
                                    }
                                    else{
                                        $uploaderFiles.append($(tmpl.replace(\'#url#\', data._data.url).replace(\'#hash#\', res.serverId).replace(\'#id#\', res.serverId)));
//                                        $uploaderFiles.append($(tmpl.replace(\'#url#\', images.localId[i]).replace(\'#hash#\', res.serverId).replace(\'#id#\', res.serverId)));
                                        i++; 
                                        alert("已上传：" + i + "/" + length); 
                                        if (i < length) { 
                                            upload(); 
                                        }
                                    }
                                  },"json");

                            }, 
                            fail: function(res) { 
                                alert(JSON.stringify(res)); 
                            } 
                        }); 
                    } 
                    upload(); 
                } 
            });
        }
        ';
        $js .= "\n";
        
        $js .= '$uploaderInput.on("click", function(e){take_a_photo();});';
        $js .= "\n";
        
        $js .= '$(".weui-gallery__del").on("click", function (e) {
                    e.preventDefault();
                    $("#" + currentHash).remove();
                    $.ajax({url:"' . $this->deleteAction . '", data:{id:currentHash}}).done(function(result){}).fail(function(result){alert(result);});
                });';
        $js .= "\n";
        return $js;
    }

}
