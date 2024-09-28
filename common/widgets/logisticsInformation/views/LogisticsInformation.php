<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 8:36
 */
$theme = $this->theme;
?>
    <?php
        if(!empty($message)){
            rsort($message);
            ?>
            <li class="col-xs-12 order-nopay-li logisticsUl">
    <div class="logistics-item latest">
        <div><?=$message[0]['AcceptTime']?></div>
        <div><?=$message[0]['AcceptStation']?></div>
        <span class="before"></span>
        <span class="after"></span>
    </div>
    <?php
    $i = 0;
    foreach($message as $mess){
        if($i > 0){
            ?>

    <div class="logistics-item hadShow" hidden>
        <div><?=$mess['AcceptTime']?></div>
        <div><?=$mess['AcceptStation']?></div>
        <span class="before"></span>
        <span class="after"></span>
    </div>
            <?php
        }
        $i++;
    }
    ?>

    <div class="color-gray tip-click">
        <span><?=Yii::t('app.c2','See detailed logistics information')?></span>
        <img src="<?= $theme->getUrl('images/tip-click.png')?>" class="tip-img">
    </div>
</li>

<?php
        }else{
     ?>
    <li class="col-xs-12 order-nopay-li logisticsLi">
        <div class="logistics-process verCenter">
            <div class="logistics-round logistics-round-color"></div>

            <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SEND)->created_at)):?>

                <div class="logistics-line logistics-line-color"></div>
            <div class="logistics-round logistics-round-color"></div>
            <?php else:?>
                <div class="logistics-line"></div>
                <div class="logistics-round"></div>
                <?php endif;?>

            <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SIGN)->created_at)):?>
                <div class="logistics-line logistics-line-color"></div>
                <div class="logistics-round logistics-round-color"></div>
            <?php else:?>
                <div class="logistics-line"></div>
                <div class="logistics-round"></div>
            <?php endif;?>
            <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_FINISH)->created_at)):?>

                <div class="logistics-line logistics-line-color"></div>
                <div class="logistics-round logistics-round-color"></div>
            <?php else:?>
                <div class="logistics-line"></div>
                <div class="logistics-round"></div>
            <?php endif;?>
        </div>
        <div class="logistics-tip col-xs-12" >
            <div class="logistics-tip-item logistics-tip-submit">
                <p class="logistics-tip-process">提交订单</p>
                <p class="logistics-tip-time"><?= Yii::$app->formatter->asDate($model->created_at);?> <br><?= Yii::$app->formatter->asTime($model->created_at)?></p>
            </div>
            <div class="logistics-tip-item logistics-tip-pay">
                <p class="logistics-tip-process">已支付</p>
                <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SEND)->created_at)):?>
                <p class="logistics-tip-time"><?= Yii::$app->formatter->asDate($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SEND)->created_at);?> <br><?= Yii::$app->formatter->asTime($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SEND)->created_at)?></p>
                <?php endif;?>
            </div>
            <div class="logistics-tip-item logistics-tip-out">
                <p class="logistics-tip-process" >已出库</p>
            <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SIGN)->created_at)):?>
                <p class="logistics-tip-time"><?= Yii::$app->formatter->asDate($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SIGN)->created_at);?> <br><?= Yii::$app->formatter->asTime($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_WAIT_SIGN)->created_at)?></p>
            <?php endif;?>
                <!--<p class="logistics-tip-time" >2017-08-31 <br>10:45:56</p>-->
            </div>
            
            <div class="logistics-tip-item logistics-tip-sign">
                <p class="logistics-tip-process" >已签收</p>
                <?php if (!empty($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_FINISH)->created_at)):?>
                    <p class="logistics-tip-time"><?= Yii::$app->formatter->asDate($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_FINISH)->created_at);?> <br><?= Yii::$app->formatter->asTime($model->getStateTime(\common\models\c2\statics\SalesOrderStateType::TYPE_FINISH)->created_at)?></p>
                <?php endif;?>

            </div>
        </div>
    </li>
    <?php
    }
    ?>



