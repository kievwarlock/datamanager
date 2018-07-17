<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'username')->textInput(['maxlength' => true] ) ?>

    <?= $form->field( $model , 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field( $model, 'email')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'newrole')->dropDownList(
        ArrayHelper::map( AuthItem::find()
            ->select('name, description')
            ->asArray()
            ->where( ['type' => 1 ])->all() , 'name', 'description')
    );
    ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
