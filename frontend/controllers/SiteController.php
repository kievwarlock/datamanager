<?php
namespace frontend\controllers;

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


/**
 * Site controller
 */
class SiteController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }



    public function actionRbac(){

      /*  $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);

        $supervisor = Yii::$app->authManager->createRole('supervisor');
        $supervisor->description = 'Супервайзер';
        Yii::$app->authManager->add($supervisor);

        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Менеджер';
        Yii::$app->authManager->add($manager);*/


          // Permits
        /*$permit = Yii::$app->authManager->createPermission('createUser');
        $permit->description = 'Право на создание юзера';
        Yii::$app->authManager->add($permit);*/

        /*$userRole = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($userRole, 1);*/


        return 'Rbac success end!';

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }



    public function actionAdd_user_to_group(){

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            if( isset($data['account_id']) and !empty($data['account_id']) and
                isset($data['group_id']) and !empty($data['group_id']) ){

                $GroupAccount = new GroupAccount();

                $GroupAccount->account_id = $data['account_id'];
                $GroupAccount->group_id = $data['group_id'];
                if( $GroupAccount->save() ){
                    return $save_model = 'Success add id = ' . $GroupAccount->id;
                }else{
                    return false;
                }

            }

        }
        return false;

    }
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionGroup123()
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
