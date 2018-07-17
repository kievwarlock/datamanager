<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Groups';
$this->params['breadcrumbs'][] = $this->title;

$all_users_array = false;

if( $users ){
    foreach ( $users as $user_item ) {
       $all_users_array[ $user_item['id'] ] = [
            'account_id' => $user_item['id'],
            'phoneNumber' => $user_item['phoneNumber'],
            'fullName' => $user_item['fullName'],
            'nickname' => $user_item['nickname'],
       ];
    }
}



?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="container">

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                if( isset($group_list) ) {

                    $tab_id = 0;
                    foreach ($group_list as $group_item ) {
                        $tab_id++;
                        ?>
                        <li role="presentation" <?= ($tab_id == 1)? 'class="active"' : ''?>>
                            <a href="#group<?=$tab_id?>"   aria-controls="home" role="tab" data-toggle="tab"><?=$group_item['name']?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="padding: 10px; border: 1px solid #ccc;">
                <?php
                if( isset($group_list) ) {
                    $tab_id = 0;
                    foreach ($group_list as $group_item ) {
                        $tab_id++;

                        ?>
                        <div role="tabpanel" class="tab-pane <?= ($tab_id == 1)? 'active' : ''?>" id="group<?=$tab_id?>">
                            <div class="well well-lg">
                                <h3>Group name: <b><?=$group_item['name']?></b></h3>
                                <p>

                                    Owner: <span class="label label-primary"><?=$group_item["owner"]['username']?></span><br>
                                    Created at: <i><?= date("F j, Y, g:i a", $group_item['created_at']); ?></i>
                                </p>
                            </div>
                            <h4>Users account:</h4>
                            <div class="well well-lg">

                                <?php


                                    $data_array_user = '';
                                    if( isset($users) and !empty($users)  ){

                                        foreach ( $users as $user ) {
                                            if( isset($without_acc) and !empty($without_acc)   ){
                                                if( !in_array( $user['id'], $without_acc )){
                                                    $data_array_user[ $user['id'] ] = $user['phoneNumber'] ;
                                                }
                                            }else{
                                                $data_array_user[ $user['id'] ] = $user['phoneNumber'] ;
                                            }

                                        }


                                    }


                                    $data_array_user_selected = '';
                                    foreach ($group_item['groupAccounts'] as $groupAccount) {
                                        $data_array_user_selected[] = $all_users_array[$groupAccount['account_id']]['account_id'];
                                    }
                                    echo '<label class="control-label">Users</label>';
                                    echo \kartik\select2\Select2::widget([
                                        'name' => 'state_2',
                                        'value' => $data_array_user_selected,
                                        'data' => $data_array_user,
                                        'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
                                    ]);



                                ?>

                            </div>
                            <h4>ADD User account:</h4>
                            <div class="well well-lg">
                                <?php

                                $without_acc = false;
                                echo 'Without: <br>';
                                foreach ($all_users as $item) {
                                    if(  $item['owner_id'] != $group_item['owner_id'] ){
                                        $without_acc[] = (int)$item['account_id'];

                                        echo $item['account_id'] . '<br>';
                                    }
                                }



                                echo 'All users: <br>';
                                $user_select = false;
                                if( isset($users) and !empty($users)  ){

                                    $user_select = '<select name="user_item" class="select-user">';
                                    foreach ($users as $user) {
                                        echo $user['id'] . '<br>';
                                        if( isset($without_acc) and !empty($without_acc)   ){
                                            if( !in_array( $user['id'], $without_acc )){
                                               $user_select .= '<option value="' . $user['id'] . '">ID:' .  $user['id']  . ' | '  . $user['phoneNumber'] . ' : ' . $user['fullName'] . '</option>';
                                            }
                                        }else{
                                            $user_select .= '<option value="' . $user['id'] . '">ID:' .  $user['id']  . ' | '  . $user['phoneNumber'] . ' : ' . $user['fullName'] . '</option>';
                                        }

                                    }
                                    $user_select .= '</select>';
                                }
                                echo $user_select;

                                ?>
                            </div>


                            <div>
                                <button class="btn btn-success add_user_to_group" data-group-id="<?=$group_item['id']?>">Add user to group</button>
                            </div>
                        </div>

                        <?php

                    }
                }
                ?>

            </div>

        </div>
        <div class="groupForm">
            <?php

            foreach ($all_users as $item) {
                echo 'OWNER:' . $item['owner_id'] . ' | ACC:' . $item['account_id'] . '<br>';
            }
            if( $return ){
                echo '<p>' . $return . '</p>';
            }

            ?>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name') ?>
            <?//= $form->field($model, 'created_at') ?>
            <?//= $form->field($model, 'updated_at') ?>
            <?//= $form->field($model, 'owner_id') ?>

            <div class="form-group">
                <?= Html::submitButton('Create group', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="bar baz">
                <!-- just like you would in a controller -->
                <?php
                //echo $this->renderPartial('about');
                ?>
            </div>
        </div><!-- _groupForm -->

    </div>
</div>
