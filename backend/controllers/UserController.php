<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update' , 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $user_role = new DynamicModel(['user_role']);
        $post_data = Yii::$app->request->post();


        if ($model->load( $post_data ) && $model->save()) {

            if( $model->id ){
                if( isset($post_data["DynamicModel"]) and isset($post_data["DynamicModel"]['user_role']) and !empty($post_data["DynamicModel"]['user_role']) ){
                    $userDefaultRole = Yii::$app->authManager->getRole($post_data["DynamicModel"]['user_role']);
                    Yii::$app->authManager->assign($userDefaultRole, $model->id);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }



        return $this->render('create', [
            'model' => $model,
            'user_role' => $user_role
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $user_role = new DynamicModel(['user_role', 'new_pass']);



        $post_data = Yii::$app->request->post();
        if( isset($post_data["DynamicModel"]['new_pass'])  and !empty($post_data["DynamicModel"]['new_pass'])   ){
            $post_data ["User"]['password_hash'] = $post_data["DynamicModel"]['new_pass'];
        }
        if ($model->load( $post_data ) && $model->save()) {

            if( $model->id ){
                if( isset($post_data["DynamicModel"]) and isset($post_data["DynamicModel"]['user_role']) and !empty($post_data["DynamicModel"]['user_role']) ){
                    $userDefaultRole = Yii::$app->authManager->getRole($post_data["DynamicModel"]['user_role']);

                    $old_user_role = array_keys(Yii::$app->authManager->getRolesByUser( $model->id ))[0];

                    if( isset( $old_user_role )){
                        $old_role = Yii::$app->authManager->getRole($old_user_role);
                        Yii::$app->authManager->revoke($old_role, $model->id);
                    }

                    Yii::$app->authManager->assign($userDefaultRole, $model->id);

                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        return $this->render('update', [
            'model' => $model,
            'user_role' => $user_role,
            //'new_pass' => $new_password,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
