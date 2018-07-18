<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = 'Create Group';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <?= $this->render('_form', [
        'selected_data' => $selected_data,
        'data_arr' => $data_arr,
        'model' => $model,
    ]) ?>

</div>
