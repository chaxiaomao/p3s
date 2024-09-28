<?php

use yii\helpers\Html;
use backend\modules\Database\modules\ProductCategory\widgets\EntityDetail;

?>
<?php

echo EntityDetail::widget([
    'model' => $model,
    'params' => $params,
    // 'withProductTab' => true,
    'withFilterTab' => true,
]);
?>