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

    <?= $form->field( $model, 'email')->textInput(['maxlength' => true]) ?>


    <?php
    if( $model->id ){
        $current_user_role = array_keys(Yii::$app->authManager->getRolesByUser( $model->id ))[0];
        if( isset( $current_user_role )){
            $user_role->user_role = $current_user_role;
        }
    }
    ?>

    <?=
    $form->field($user_role, 'user_role')
        ->dropDownList(
        ArrayHelper::map( AuthItem::find()
        ->select('name, description')
        ->asArray()
        ->where( ['type' => 1 ])->all() , 'name', 'description')
    );
    ?>

    <?= $form->field( $user_role, 'new_pass')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
