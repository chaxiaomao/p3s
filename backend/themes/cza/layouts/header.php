<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

// $directoryAsset = \Yii::$app->czaHelper->getEnvData('AdminlteAssets');
?>

<style>
    .main-header .sidebar-cl:before {
        content: "" !important;
    }
</style>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::t('app.c2', 'Pache Console') . '</span>', Yii::$app->homeUrl, ['destination' => 'main-content-pjax', 'class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php
            if (\Yii::$app->user->can('P_CL')) {
                echo '<a href="javascript:;" class="sidebar-toggle sidebar-cl">CL管理</a>';
            }
        ?>
        <!--        <a href="#" class="sidebar-toggle sidebar-cl">CL管理</a>-->

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= \Yii::$app->user->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

                            <p>
                                <?= \Yii::$app->user->fullname ?>
                                <!--<small>Member since Nov. 2012</small>-->
                            </p>
                        </li>
                        <!-- User image -->
                        <!-- Menu Body -->
                        <!--                        <li class="user-body">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Followers</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Sales</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Friends</a>
                                                    </div>
                                                </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--                            <div class="pull-left">
                                <?= Html::a('Profile', ['/my-space/profile'], ['destination' => 'main-content-pjax', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>-->
                            <div class="pull-right">
                                <?=
                                Html::a(
                                        Yii::t('app.c2', 'Sign out'), ['/user/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat'
                                        ]
                                )
                                ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
