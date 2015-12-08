<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use app\modules\admin\models\Event;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $user = User::findOne(Yii::$app->user->id);
        if(!$user){
            if($action->id != 'login' || $action->controller->id != 'default'){
                return Yii::$app->getResponse()->redirect(['/admin/default/login']);
            }
        }

        if($user && $user->role < User::ROLE_STAFF){
            Yii::$app->getSession()->setFlash('error', 'You does not have permission.');
            return $this->redirect(['/admin']);
        }

        return true; // or false to not run the action
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$admin = User::findOne(Yii::$app->user->id);

        /*$dataProvider = new ActiveDataProvider([
            'query' => User::find()
                            ->select([
                                '{{user}}.*', 
                                'COUNT({{event}}.id) AS eventsCount' 
                            ])
                            ->joinWith('events')
                            ->where('role < :staff', [':staff' => User::ROLE_STAFF])
                            ->andWhere('visibility = :visibility', [':visibility' => Event::VISIBILITY_PUBLIC])
                            ->groupBy('{{user}}.id'),
        ]);*/

        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where('role < :staff', [':staff' => User::ROLE_STAFF]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
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
        $signup = new SignupForm(['scenario' => 'signup']);

        if(Yii::$app->request->isPost){
            $signup->load(Yii::$app->request->post());

            if ($user = $signup->signup()) {

                $model->load(Yii::$app->request->post());
                $user->role = $model->role;
                $user->save();

                return $this->redirect(['view', 'id' => $user->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'signup' => $signup,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
