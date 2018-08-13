<?php

namespace frontend\controllers;

use app\models\UserDataModel;
use app\models\AvatarDataModel;
use Yii;


class UserController extends MainController
{


    public function actionView()
    {



        if (Yii::$app->request->isAjax) {


            $data = Yii::$app->request->post();


            if( isset( $data['user_id'] ) and !empty( $data['user_id'] )   and
                isset( $data['user_token'] ) and !empty( $data['user_token'] ) ){

                $UserDataModel = new UserDataModel();


                $user_data = $UserDataModel->getUserProfile( $data['user_id'], $data['user_token'] );



                if( $user_data['status'] === true){

                    $avatar_base64 = false;

                    if( isset($user_data['data']["avatarId"]) and !empty($user_data['data']["avatarId"]) ) {
                        $model = new AvatarDataModel();
                        $avatar_base64 = $model->getAvatar($user_data['data']["avatarId"], $data['user_token'], 'original' );

                    }

                    return $this->renderajax('modal-view-account',[
                        'full_user_data' => $user_data['data'],
                        'token' => $data['user_token'],
                        'avatar' => $avatar_base64
                    ]);

                }else{
                    return 'ERROR!' . $user_data['error'];
                }


            }

        }

        return false;


    }



}
