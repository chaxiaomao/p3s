<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

yii\bootstrap\BootstrapAsset::register($this);

$theme = $this->theme;
$this->registerCssFile($theme->getUrl('css/print.css'));
?>

<?php
$js = <<<_JS
document.getElementById("btn-print").onclick = function () {
    printElement(document.getElementById("print-content"));
};
function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var printContent = document.getElementById("printSection");

    if (!printContent) {
        var printContent = document.createElement("div");
        printContent.id = "printSection";
        document.body.appendChild(printContent);
    }

    printContent.innerHTML = "";
    printContent.appendChild(domClone);
    window.print();
}
_JS;
$this->registerJs($js);
?>

<style>
    * {
        font-size: 15px;
    }

    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #0a0a0a !important;
        padding: 0 !important;
    }

    .modal-body {
        padding: 5px !important;
    }

    h2 {
        margin: 4px !important;
        padding: 0;
    }

    .p20 {
        padding: 20px;
    }

    .tc {
        text-align: center;
    }

    .pt10 {
        padding-top: 10px;
    }

    .mt10 {
        margin-top: 10px;
    }

    .box60 {
        min-width: 60px;
    }

    .box120 {
        min-width: 120px;
    }

    .box160 {
        min-width: 160px;
    }

    .box200 {
        min-width: 200px;
    }

    .box300 {
        min-width: 300px;
    }

    .memo {
        min-width: 150px;
    }
</style>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="screen-orientation" content="portrait">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"-->
    <!--          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <?php $this->head() ?>
</head>
<body class="bg-f5">
<?php $this->beginBody() ?>

<div id="print-content" class="modal-body">
    <?= $content; ?>
</div>

<div class="modal-footer">
    <div class="pull-left">
    </div>

    <div class="pull-left hidden-print">
        <button class="btn btn-primary" id="btn-print"><?= Yii::t('app.c2', "Print") ?></button>
        <!--        <button class="btn btn-primary" data-dismiss="modal">-->
        <? //= Yii::t('app.c2', "Close") ?><!--</button>-->
        <a class="btn btn-primary"
           href="javascript:window.opener=null;window.close();"><?= Yii::t('app.c2', "Close") ?></a>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

