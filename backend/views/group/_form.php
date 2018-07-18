<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?//= $form->field($model, 'owner_id')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>
    <?php

    $data = \yii\helpers\ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'username');


    echo $form->field($model, 'owner_id')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'Select group owner...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?php

    $model->accounts = $selected_data;
    echo $form->field($model, 'accounts')->widget(Select2::classname(), [
        'value' => $selected_data,
        'data' => $data_arr,

        'options' => ['multiple' => true, 'placeholder' => 'Select accounts ...'],

    ]);

    ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
