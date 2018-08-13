<?php
namespace frontend\controllers;

use app\models\UserDataModel;
use backend\controllers\MainController;
use common\models\Group;
use common\models\GroupAccount;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\DataUsers;
use common\models\UserAccount;

/**
 * Site controller
 */
class GroupController extends MainController
{
    /**
     * {@inheritdoc}
     */
   /* public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'rbac','group'],
                'rules' => [
                   [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                   [
                        'actions' => ['rbac'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['group'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/



    public function actionUnlink()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();


            if( $data and isset( $data['accounts'] ) ) {

                $current_user_id = Yii::$app->user->id;
                foreach ($data['accounts'] as $account_id ) {
                    $unlink_account = UserAccount::find()
                        ->where( ['user_id' => $current_user_id ] )
                        ->andwhere( ['account_id' => $account_id] )
                        ->one();
                    if($unlink_account){
                        $unlink_account->delete();
                    }


                }

                $userDataModel = new UserDataModel();

                $users_data = $userDataModel->getUsersArray();



                // All Users from server
                if($users_data['status'] === true ){



                    $current_user_accounts = UserAccount::find()
                        ->asArray()
                        ->where( ['=', 'user_id', Yii::$app->user->id ] )
                        ->all();

                    $diff_user_accounts = UserAccount::find()
                        ->asArray()
                        ->where( ['!=', 'user_id', Yii::$app->user->id ] )
                        ->all();


                    // Get profile Users from server if user Add to account user list
                    $users_profile = false;
                    $users_profile_add_list = false;
                    foreach ( $users_data['data'] as $user ) {
                        if( in_array( $user['id'], array_column($current_user_accounts, 'account_id') ) ) {
                            $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                            if ($profile['status'] === true) {
                                $users_profile[] = $profile['data'];
                            }
                        }else{

                            if( !in_array( $user['id'], array_column($diff_user_accounts, 'account_id') ) ) {
                                $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                                if ($profile['status'] === true) {
                                    $users_profile_add_list[] = $profile['data'];
                                }
                            }
                        }
                    }

                    // Get profile Users from server
                    /*   $users_profile = false;
                       foreach ( $users_data['data'] as $user ) {

                           $profile = $userDataModel->getUserProfile($user['id'],$user['token'] );
                           if($profile['status'] === true ){
                               $users_profile[] = $profile['data'];
                           }

                       }*/
                    /*
                                if( Yii::$app->user->can('admin') ){
                                    $where = [];
                                }else{
                                    //$where = ['owner_id' => Yii::$app->user->id];
                                    $where = [];
                                }*/

                    $where = [];


                    // Get group list
                    $group_list = Group::find()
                        ->with(['owner' => function($query) {
                            $query->addSelect(['id', 'username']);
                        },
                            'groupAccounts' => function($query) {
                                $query->addSelect(['group_id', 'account_id']);
                            },
                        ])
                        ->asArray()
                        ->where( $where )
                        ->all();


                    return $this->renderAjax('index',[
                        'add_list_accounts' => $users_profile_add_list,
                        'accounts'  => $users_profile ,
                        'groups'    => $group_list,
                    ]);



                }else{
                    return $this->render('index',[
                        'accounts' => '' ,
                        'error' => $users_data['error']
                    ]);
                }

            }



        }

    }


    public function actionLink()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            if( $data and isset( $data['accounts'] ) ) {

                $current_user_id = Yii::$app->user->id;
                foreach ($data['accounts'] as $account_id ) {
                    $new_attach_account = new UserAccount();
                    $new_attach_account->account_id = $account_id;
                    $new_attach_account->user_id = $current_user_id;
                    $new_attach_account->save();
                }

                $userDataModel = new UserDataModel();

                $users_data = $userDataModel->getUsersArray();



                // All Users from server
                if($users_data['status'] === true ){



                    $current_user_accounts = UserAccount::find()
                        ->asArray()
                        ->where( ['=', 'user_id', Yii::$app->user->id ] )
                        ->all();

                    $diff_user_accounts = UserAccount::find()
                        ->asArray()
                        ->where( ['!=', 'user_id', Yii::$app->user->id ] )
                        ->all();


                    // Get profile Users from server if user Add to account user list
                    $users_profile = false;
                    $users_profile_add_list = false;
                    foreach ( $users_data['data'] as $user ) {
                        if( in_array( $user['id'], array_column($current_user_accounts, 'account_id') ) ) {
                            $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                            if ($profile['status'] === true) {
                                $users_profile[] = $profile['data'];
                            }
                        }else{

                            if( !in_array( $user['id'], array_column($diff_user_accounts, 'account_id') ) ) {
                                $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                                if ($profile['status'] === true) {
                                    $users_profile_add_list[] = $profile['data'];
                                }
                            }
                        }
                    }

                    // Get profile Users from server
                    /*   $users_profile = false;
                       foreach ( $users_data['data'] as $user ) {

                           $profile = $userDataModel->getUserProfile($user['id'],$user['token'] );
                           if($profile['status'] === true ){
                               $users_profile[] = $profile['data'];
                           }

                       }*/
                    /*
                                if( Yii::$app->user->can('admin') ){
                                    $where = [];
                                }else{
                                    //$where = ['owner_id' => Yii::$app->user->id];
                                    $where = [];
                                }*/

                    $where = [];


                    // Get group list
                    $group_list = Group::find()
                        ->with(['owner' => function($query) {
                            $query->addSelect(['id', 'username']);
                        },
                            'groupAccounts' => function($query) {
                                $query->addSelect(['group_id', 'account_id']);
                            },
                        ])
                        ->asArray()
                        ->where( $where )
                        ->all();


                    return $this->renderAjax('index',[
                        'add_list_accounts' => $users_profile_add_list,
                        'accounts'  => $users_profile ,
                        'groups'    => $group_list,
                    ]);



                }else{
                    return $this->render('index',[
                        'accounts' => '' ,
                        'error' => $users_data['error']
                    ]);
                }

            }



        }

    }

    public function actionIndex()
    {




        $userDataModel = new UserDataModel();

        $users_data = $userDataModel->getUsersArray();



        // All Users from server
        if($users_data['status'] === true ){



            $current_user_accounts = UserAccount::find()
                ->asArray()
                ->where( ['=', 'user_id', Yii::$app->user->id ] )
                ->all();

            $diff_user_accounts = UserAccount::find()
                ->asArray()
                ->where( ['!=', 'user_id', Yii::$app->user->id ] )
                ->all();


            // Get profile Users from server if user Add to account user list
            $users_profile = false;
            $users_profile_add_list = false;
            foreach ( $users_data['data'] as $user ) {
                if( in_array( $user['id'], array_column($current_user_accounts, 'account_id') ) ) {
                    $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                    if ($profile['status'] === true) {
                        $users_profile[$user['token']] = $profile['data'];
                    }
                }else{

                    if( !in_array( $user['id'], array_column($diff_user_accounts, 'account_id') ) ) {
                        $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                        if ($profile['status'] === true) {
                            $users_profile_add_list[] = $profile['data'];
                        }
                    }
                }
            }

            // Get profile Users from server
         /*   $users_profile = false;
            foreach ( $users_data['data'] as $user ) {

                $profile = $userDataModel->getUserProfile($user['id'],$user['token'] );
                if($profile['status'] === true ){
                    $users_profile[] = $profile['data'];
                }

            }*/
/*
            if( Yii::$app->user->can('admin') ){
                $where = [];
            }else{
                //$where = ['owner_id' => Yii::$app->user->id];
                $where = [];
            }*/

            $where = [];


            // Get group list
            $group_list = Group::find()
                ->with(['owner' => function($query) {
                    $query->addSelect(['id', 'username']);
                },
                    'groupAccounts' => function($query) {
                        $query->addSelect(['group_id', 'account_id']);
                    },
                ])
                ->asArray()
                ->where( $where )
                ->all();


                return $this->render('index',[
                    'add_list_accounts' => $users_profile_add_list,
                    'accounts'  => $users_profile ,
                    'groups'    => $group_list,
                ]);



        }else{
            return $this->render('index',[
                'accounts' => '' ,
                'error' => $users_data['error']
            ]);
        }




    }

    public function actionCreate(){

        if (Yii::$app->request->isAjax) {

            $return_array = false;
            $data = Yii::$app->request->post();

            if ( $data and isset($data['group-name']) and isset($data['accounts']) ) {

                $new_group = new Group();
                $new_group->name = $data['group-name'];
                $new_group->owner_id = Yii::$app->user->id;

                if( $new_group->save() ){
                    $return_array['group']['id'] = $new_group->id;
                    $new_group_id = $new_group->id;

                    if( is_array($data['accounts'] )){
                        foreach ($data['accounts'] as $account) {
                            $GroupAccount = new GroupAccount();
                            $GroupAccount->account_id = $account;
                            $GroupAccount->group_id = $new_group_id;

                            if( $GroupAccount->save() ){
                                $return_array['account_attach'][$account] = $GroupAccount->id;
                            }else{
                                return false;
                            }

                        }
                    }

                }else{
                    return false;
                }


                return true;

            }
        }

    }



    public function actionGroup()
    {

        $DataUsers = new DataUsers();


        $users_array = [
            '3' => '3:z3vf9939hTfqa4FA',
            '11' => '11:jagt2E61R1ez9L6F',
            '12' => '12:lL3WPw9riWMukbQB',
            '4' => '4:1O2iEJ9l7zE6EEWn',
            '13' => '13:remK264vmMXPcEZb',
            '5' => '5:cTfbYHjpzUVBPkzG',
            '6' => '	6:cI2J3Yoar8OeltLl',
            '7' => '7:p80InvPzd0W928wA',
            '8' => '8:uw7xcF5TL8Qwaql3',
            '9' => '9:HWL1ijSqCk9uiSze',
        ];
        return 'Need new api';
        $users = false;
        if( $users_array ){
            foreach ($users_array as $user_id => $user_token) {
                //$users[] = json_decode( $DataUsers->getUserProfile($user_id, $user_token) , true);
            }
        }



        $save_model = false;
        $model = new Group();

        if( Yii::$app->request->post() ){
            $post_group = Yii::$app->request->post();
            //var_dump($post_group);
            $post_group["Group"]['owner_id'] = Yii::$app->user->id;

            if($model->load( $post_group ) && $model->save()){
                $save_model = 'Success save with id = ' . $model->id;
            }

        }

        if( Yii::$app->user->can('admin') ){
            $where = [];
        }else{
            $where = ['owner_id' => Yii::$app->user->id];
        }


        $sql = 'SELECT DISTINCT(account_id),owner_id FROM `group` AS g  JOIN `group_account` AS ga ON ga.group_id = g.id ';

        $users_select = GroupAccount::findBySql($sql)->asArray()->all();

   /*     $users_select = Group::find()
            ->with([
            'groupAccounts' => function($query) {
                //$query->addSelect(['account_id']);
            },
            ])
            ->asArray()
            ->where( 'owner_id != ' . Yii::$app->user->id )
            ->all();*/


        $group_list = Group::find()
        ->with(['owner' => function($query) {
                $query->addSelect(['id', 'username']);
            },
                'groupAccounts' => function($query) {
                    $query->addSelect(['group_id', 'account_id']);
                },
            ])
            ->asArray()
            ->where( $where )
            ->all();

        return $this->render('group', [
            'group_list' => $group_list,
            'model' => $model,
            'return' => $save_model,
            'users' => $users,
            'all_users' => $users_select
        ]);
    }


}
