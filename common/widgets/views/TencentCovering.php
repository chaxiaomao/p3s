<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 18:36
 */
use yii\helpers\Html;
use cza\base\assets\TencentMapAsset;
use yii\web\View;

$theme = $this->theme;
$options = $this->context->options;
$maker = $this->context->mapOptions;
TencentMapAsset::register($this);
?>
<?php

echo Html::beginTag('div', $options);
echo Html::endTag('div');
?>

<?php

$js = "";
//$js .= " window.onload = function() { ";
$js .= "\n";
$js .= "";
foreach ($maker['marker'] as $num => $item) {
    $js .= " var center" . ($num + 1) . "= new qq.maps.LatLng(" . $item['coord'] . ");";
    $js .= "\n";
}
$js .= "var mycenter = null;";
$js .= "if(center1 == null){  
                 mycenter = center2;
              }else{  
                 mycenter = center1;
              }";
$js .= " var map = new qq.maps.Map(document.getElementById('container'),{
            center: mycenter,
            zoom: 13
            });";
$js .= "\n";
foreach ($maker['marker'] as $num => $item) {
    $js .= "var marker" . ($num + 1) . "=new qq.maps.Marker({
            position:center" . ($num + 1) . ",
		      	animation:qq.maps.MarkerAnimation.DROP,
                map:map,
                content:'文本标注" . ($num + 1) . "'
            });";
    $js .= " var infoWin" . ($num + 1) . "= new qq.maps.InfoWindow({
                map: map,
                position: center" . ($num + 1) . ",
                 zIndex: 10,
                 visible: true
            });";
    $js .= "\n";
    $js .= "infoWin" . ($num + 1) . ".open();";
    $js .= "\n";
    if(array_key_exists('addr', $item)) {
        $js .= "infoWin" . ($num + 1) . ".setContent('<div style=\"width:200px;padding-top:10px;\">'+'" . $item['title'] . "<div>地址:" . $item['addr'] . "</div><div>电话:" . $item['mobile'] . "<div><a href=" . \yii\helpers\Url::to(['find-address', 'coord' => $item['coord']]) . "><div>到这里</div></a></div></div>');";
    } else {
        $js .= "infoWin" . ($num + 1) . ".setContent('<div style=\"width:200px;padding-top:10px;\">未设置</div>');";
    }
    $js .= "\n";
    $js .= "infoWin" . ($num + 1) . ".setPosition(center" . ($num + 1) . ");";
    $js .= "\n";
}


$js .= "\n";
//$js .= "}";
$js .= "\n";
$this->registerJs($js);
?>

<?php

if ($this->context->showMePos && Yii::$app->wechat->isWechat) {
    $js .= "\n";
    $js .= "wx.ready(function () {
                wx.getLocation({
                      success: function (res) {
                            // convert to extract coordinate
                            qq.maps.convertor.translate(new qq.maps.LatLng(res.latitude, res.longitude), 2, function(res) {
                                var realRes = res[0];
//console.log('sth');
//console.log(realRes);
                                var myPos = new qq.maps.LatLng(realRes.lat, realRes.lng);
                                var myPosMarker = new qq.maps.Marker({
                                                    position: myPos,
                                                    animation: qq.maps.MarkerAnimation.BOUNCE,
                                                    map: map
                                                });
                                myPosMarker.setVisible(true);
                            });
                      },
                      cancel: function (res) {
                        alert('" . Yii::t('app.c2', 'Since user refuse geogrephy access, the map cannot be opened!') . "');
                      }
                });
            });";

    $this->registerJs($js);
}
?>



