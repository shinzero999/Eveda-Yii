<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;
use app\modules\admin\models\Dealer;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
    	if (!Yii::$app->user->isGuest) {
            return $this->afterLogin();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();

            if($user->status != User::STATUS_ACTIVE){
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Your account is not active.');

                return $this->refresh();
            }

            if ($user->role >= User::ROLE_STAFF){
                return $this->redirect(['/admin']);
            } else {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'You do not have permission.');

                return $this->refresh();
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function afterLogin(){
        $user = User::findOne(Yii::$app->user->id);

        if($user){
            if ($user->role >= User::ROLE_STAFF){
                return $this->redirect(['/admin']);
            } 
        }

    }
}
