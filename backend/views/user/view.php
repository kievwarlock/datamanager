<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,

        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'role.description',
            //'status',
            //'created_at',
            //'updated_at',
            /*[                      // the owner name of the model
                'label' => 'Role',
                'value' => function($data){
                    $userRole = array_keys( Yii::$app->authManager->getRolesByUser($data->id) );
                   // return $data->getRole()->asArray()->one()['description'];
                    return $userRole[0];
                },
            ]*/
        ],


    ]) ?>
    <p>
        <?php
        //var_dump($model->getAuthAssignment()->asArray()->one() );
        //echo '<hr>';
        //var_dump( $model->getRole()->asArray()->one() );
        ?>
    </p>
</div>
