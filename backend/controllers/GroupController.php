<?php

namespace backend\controllers;

use Yii;
use common\models\Group;
use common\models\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();


        $users_data = [
            '3' => '3:z3vf9939hTfqa4FA',
            '11' => '11:jagt2E61R1ez9L6F',
            '12' => '12:lL3WPw9riWMukbQB',
            '4' => '4:1O2iEJ9l7zE6EEWn',
            '13' => '13:remK264vmMXPcEZb',
            '5' => '5:cTfbYHjpzUVBPkzG',
            '6' => '6:cI2J3Yoar8OeltLl',
            '7' => '7:p80InvPzd0W928wA',
            '8' => '8:uw7xcF5TL8Qwaql3',
            '9' => '9:HWL1ijSqCk9uiSze',
        ];
        $data_arr = '';
        foreach ($users_data as $data_key => $data_val) {
            $data_arr[$data_key] = $data_key;
        }
        $selected_data = \yii\helpers\ArrayHelper::map($model->groupAccounts, 'account_id', 'account_id');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'selected_data' => $selected_data,
            'data_arr' => $data_arr
        ]);
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $users_data = [
            '3' => '3:z3vf9939hTfqa4FA',
            '11' => '11:jagt2E61R1ez9L6F',
            '12' => '12:lL3WPw9riWMukbQB',
            '4' => '4:1O2iEJ9l7zE6EEWn',
            '13' => '13:remK264vmMXPcEZb',
            '5' => '5:cTfbYHjpzUVBPkzG',
            '6' => '6:cI2J3Yoar8OeltLl',
            '7' => '7:p80InvPzd0W928wA',
            '8' => '8:uw7xcF5TL8Qwaql3',
            '9' => '9:HWL1ijSqCk9uiSze',
        ];
        $data_arr = '';
        foreach ($users_data as $data_key => $data_val) {
            $data_arr[$data_key] = $data_key;
        }
        $selected_data = \yii\helpers\ArrayHelper::map($model->groupAccounts, 'account_id', 'account_id');



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'selected_data' => $selected_data,
            'data_arr' => $data_arr
        ]);
    }

    /**
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
