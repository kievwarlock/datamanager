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

    public function actionIndex(){
        return $this->renderPage();
    }

    // UNLink accounts to group
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

                return $this->renderPage();

            }



        }
        return false;
    }

    // Link accounts to group
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

                return $this->renderPage();

            }



        }
        return false;
    }

    // Create group
    public function actionCreate(){

        if (Yii::$app->request->isAjax) {

            $return_array = false;
            $data = Yii::$app->request->post();

            if ( $data and isset($data['group-name']) ) {

                $tab = 'all_groups';

                $new_group = new Group();
                $new_group->name = $data['group-name'];
                $new_group->owner_id = Yii::$app->user->id;

                if( $new_group->save() ){

                    if( isset($data['accounts']) ) {

                        $tab = 'all_accounts';
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
                    }

                }else{
                    return false;
                }

                return $this->renderPage( $tab);


            }
        }

        return false;

    }

    // Delete group
    public function actionDelete()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();


            if( $data and isset( $data['groups'] ) ) {

                $current_user_id = Yii::$app->user->id;
                foreach ($data['groups'] as $group_id ) {
                    $delete_group = Group::find()
                        ->where( ['owner_id' => $current_user_id ] )
                        ->andwhere( ['id' => $group_id] )
                        ->one();
                    if($delete_group){
                        $delete_group->delete();
                    }
                }

                return $this->renderPage( 'all_groups' );

            }




        }

        return false;

    }


    // Update group
    public function actionUpdate()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();


            if( $data and isset( $data['groups']) and isset($data['group_id']) ) {


                $group = Group::find()
                    ->where( ['id' => $data['group_id'] ] )
                    ->with(['groupAccounts'])
                    ->asArray()
                    ->one();

                if(  $group["groupAccounts"] and count($group["groupAccounts"]) > 0 ) {
                    // Group accounts
                    $group_account = array_column($group["groupAccounts"], 'account_id' );
                }else{
                    $group_account = array();
                }


                $insert_accounts = array_diff($data['groups'],$group_account );
                $delete_accounts = array_diff($group_account, $data['groups'] );

                if( is_array($delete_accounts) and count($delete_accounts) > 0 ) {

                    foreach ($delete_accounts as $delete_account_id) {
                        $del_account = GroupAccount::find()
                            ->where( ['group_id' => $data['group_id'] ] )
                            ->andwhere( ['account_id' => $delete_account_id] )
                            ->one();
                        if($del_account){
                            $del_account->delete();
                        }
                    }
                }
                if( is_array($insert_accounts) and count($insert_accounts) > 0 ) {
                    foreach ($insert_accounts as $insert_account_id ) {
                        $new_account = new GroupAccount();
                        $new_account->group_id = $data['group_id'];
                        $new_account->account_id = $insert_account_id;
                        $new_account->save();
                    }
                }

                return $this->renderPage( 'all_groups' );

            }

        }

        return false;

    }




    // View group
    public function actionView()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();


            if( $data and isset( $data['group-id'] ) ) {



                $group = Group::find()
                    ->where( ['id' => $data['group-id'] ] )
                    ->with(['groupAccounts'])
                    ->asArray()
                    ->one();

                //return var_dump($group);

                if(  $group["groupAccounts"] and count($group["groupAccounts"]) > 0 ) {
                    // Group accounts
                    $group_account = array_column($group["groupAccounts"], 'account_id' );
                }else{
                    $group_account = array();
                }

                if( $group['owner_id'] ){

                    // User accounts
                    $owner_accounts = UserAccount::find()
                        ->where( ['user_id' => $group['owner_id'] ] )
                        ->asArray()
                        ->all();

                    if( is_array($owner_accounts) and count($owner_accounts) > 0 ){
                        $owner_accounts = array_column($owner_accounts, 'account_id' );
                    }else{
                        $owner_accounts = array();
                    }

                }



                $userDataModel = new UserDataModel();
                $users_data = $userDataModel->getUsersArray();

                // All Users from server
                if( $users_data['status'] === true ) {

                    if( is_array($group_account) and is_array($owner_accounts) and is_array( $users_data['data'] ) ){

                        $accounts_list = array_diff( $owner_accounts, $group_account );

                        $data_array = array(
                            'owner_accounts' => array(),
                            'group_accounts' => array(),
                        );
                        foreach ( $users_data['data'] as $account ) {
                            if( in_array($account['id'], $accounts_list )  ){

                                $profile = $userDataModel->getUserProfile($account['id'], $account['token']);
                                if ($profile['status'] === true) {
                                    $data_array['owner_accounts'][] = $profile['data'];
                                }

                            }
                            if( in_array($account['id'], $group_account )  ){

                                $profile = $userDataModel->getUserProfile($account['id'], $account['token']);
                                if ($profile['status'] === true) {
                                    $data_array['group_accounts'][] = $profile['data'];
                                }

                            }
                        }

                        return $this->renderAjax('modals/group-view',[
                            'owner_accounts' => $data_array['owner_accounts'],
                            'group_accounts' => $data_array['group_accounts'],
                            'group_id' => $data['group-id'],
                        ]);


                    }

                }


            }

        }

        return false;

    }




    // private methods

    private function getAccounts() {

        $userDataModel = new UserDataModel();
        $users_data = $userDataModel->getUsersArray();


        // All Users from server
        if($users_data['status'] === true ) {

            $current_user_accounts = UserAccount::find()
                ->asArray()
                ->where(['=', 'user_id', Yii::$app->user->id])
                ->all();

            $diff_user_accounts = UserAccount::find()
                ->asArray()
                ->where(['!=', 'user_id', Yii::$app->user->id])
                ->all();

            // Get profile Users from server if user Add to account user list

            $users_profile = false;
            $users_profile_add_list = false;

            foreach ($users_data['data'] as $user) {

                if (in_array($user['id'], array_column($current_user_accounts, 'account_id'))) {
                    $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                    if ($profile['status'] === true) {
                        $users_profile[$user['token']] = $profile['data'];
                    }
                } else {

                    if (!in_array($user['id'], array_column($diff_user_accounts, 'account_id'))) {
                        $profile = $userDataModel->getUserProfile($user['id'], $user['token']);
                        if ($profile['status'] === true) {
                            $users_profile_add_list[] = $profile['data'];
                        }
                    }
                }
            }
            $return['user_accounts'] = $users_profile;
            $return['user_accounts_add_list'] = $users_profile_add_list;

            return $return;
        }

        return false;

    }


    private function getGroups() {


		if( Yii::$app->user->can('admin') ){
			$where = [];
		}else{
			$where = ['owner_id' => Yii::$app->user->id];
		}

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

        return $group_list;

    }


    private function renderPage( $tab = 'all_accounts' ){

        $params = [];
        $params['tab'] = $tab;

        $accounts = $this->getAccounts();
        if( is_array($accounts) ){

            if( is_array( $accounts['user_accounts'] ) ){
                $params['accounts'] = $accounts['user_accounts'];
            }
            if( is_array( $accounts['user_accounts_add_list'] ) ){
                $params['add_list_accounts'] = $accounts['user_accounts_add_list'];
            }

        }

        $groups = $this->getGroups();
        if( is_array($groups) ){
            $params['groups'] = $groups;
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index',$params );
        }else{
            return $this->render('index',$params );
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
