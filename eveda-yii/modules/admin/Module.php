<?php

namespace app\modules\admin;

use Yii;
use app\models\User;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'app\modules\admin\controllers';

	public function init()
	{
		parent::init();

		// custom initialization code goes here
		$this->layout = 'backend';
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
			return $this->goHome();
		}

		return true; // or false to not run the action
	}

	public function goHome(){
		return Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
	}
}
