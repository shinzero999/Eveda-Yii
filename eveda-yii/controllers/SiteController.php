<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\LoginForm;
use app\models\User;
use app\modules\admin\models\Region;
use app\modules\admin\models\Genre;
use app\modules\admin\models\Event;
use app\modules\admin\models\EventPost;
use app\modules\admin\models\Upgrade;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$self = $this;

		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup'],
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
				],
				'denyCallback' => function($rule, $action) use ($self) {
					if('signup' == $action->id){
						return $self->afterLogin();
					} else {
						return $self->redirect(['site/index']);
					}
				}
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
				
				],
			],
			'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
		];
	}

	public function init()
	{
		$this->enableCsrfValidation = false;
	}

	/**
	 * @inheritdoc
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

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionSignup()
	{
		$signup = new SignupForm(['scenario' => 'signup']);
		$user = new User();

		$signup->email = Yii::$app->request->post('email');
		$signup->password = Yii::$app->request->post('password');
		$signup->display_name = Yii::$app->request->post('display_name');

		if ($user = $signup->signup()) {
			$user->role = User::ROLE_USER;
			$user->save();
			
			return json_encode(['success' => true, 'data' => $user->attributes]);

		} else if($signup->hasErrors()) {
			return json_encode(['success' => false, 'data' => $signup->getErrors()]);
		} 
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			$user = User::findOne(Yii::$app->user->id);
			return json_encode(['success' => true, 'data' => $user->attributes]);
		}

		$login = new LoginForm();
		$login->email = Yii::$app->request->post('email');
		$login->password = Yii::$app->request->post('password');

		if ($login->login()) {
			$user = $login->getUser();

			return json_encode(['success' => true, 'data' => $user->attributes]);
		} else {
			if($login->hasErrors()){
				return json_encode(['success' => false, 'data' => $login->getErrors()]);
			}
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	public function actionGetRegions() {
		$regions = Region::find()->all();
		return json_encode(['success' => true, 'data' => ArrayHelper::toArray($regions)]);
	}

	public function actionGetGenres() {
		$genres = Genre::find()->all();
		return json_encode(['success' => true, 'data' => ArrayHelper::toArray($genres)]);
	}

	public function actionCreateEvent() {
		$user = User::findOne(Yii::$app->request->post('user_id'));

		if (!$user) {
			return json_encode(['success' => false, 'data' => ['User not found.']]);
		}

		$region = Region::findOne(Yii::$app->request->post('region_id'));

		if (!$region) {
			return json_encode(['success' => false, 'data' => ['Region not found.']]);
		}

		$genre = Genre::findOne(Yii::$app->request->post('genre_id'));

		if (!$genre) {
			return json_encode(['success' => false, 'data' => ['Genre not found.']]);
		}

		$start_date = new \DateTime(Yii::$app->request->post('start_date'));
		$end_date = new \DateTime(Yii::$app->request->post('end_date'));

		$event = new Event();
		$event->user_id = $user->id;
		$event->title = Yii::$app->request->post('title');
		$event->location = Yii::$app->request->post('location');
		$event->start_date = $start_date->format('Y-m-d H:i:s');
		$event->end_date = $end_date->format('Y-m-d H:i:s');
		$event->url = Yii::$app->request->post('url');
		$event->notes = Yii::$app->request->post('notes');
		$event->image = Yii::$app->request->post('image');
		$event->visibility = Yii::$app->request->post('visibility');
		$event->region_id = $region->id;
		$event->genre_id = $genre->id;

		if ($event->save()) {
			if ($event->visibility == Event::VISIBILITY_PUBLIC) {
				$eventPost = new EventPost();
				$eventPost->event_id = $event->id;
				$eventPost->status = EventPost::STATUS_NEW;
				$eventPost->save();
			}
			
			return json_encode(['success' => true, 'data' => '']);
		} else {
			return json_encode(['success' => false, 'data' => $event->getErrors()]);
		}
		
	}

	public function actionIsPremium() {
		$user = User::findOne(Yii::$app->request->post('id'));

		if ($user) {
			return json_encode(['success' => true, 'data' => $user->isPremium()]);
		} 
	}

	public function actionGetPublicEvents() {
		$regionName = Yii::$app->request->post('regionName');
		if ($regionName) {
			$events = Event::find()
				->joinWith('eventPosts')
				->joinWith('genre')
				->joinWith('region')
				->where(['like', 'region.name', $regionName])
				->andWhere('status = :status', [':status' => EventPost::STATUS_POST])
				->andWhere('DATE(end_date) >= CURDATE()')->all();

			return json_encode(['success' => true, 'data' => ArrayHelper::toArray($events, [
					'app\modules\admin\models\Event' => [
						'id',
						'user',
						'title',
						'location',
						'start_date',
						'end_date',
						'url',
						'notes',
						'image',
						'region',
						'genre',
					]
				])]);
		}
	}

	public function actionGetNumberOfEvents() {
		$now = new \DateTime(Yii::$app->request->post('now'));
		$nextMonth = new \DateTime(Yii::$app->request->post('nextMonth'));

		$array = [];
		for ($date = $now; $date < $nextMonth; $date->modify('+1 day')) { 
			$hasEvent = true;
			$event = Event::find()
					->joinWith('eventPosts')
					->where(['like', 'DATE(start_date)', $date->format('Y-m-d')])
					->andWhere('status = :status', [':status' => EventPost::STATUS_POST])
					->one();

			if ($event) {
				$hasEvent = true;
			} else {
				$hasEvent = false;
			}

			$array[] = [
				'date' => $date->format('Y-m-d H:i:s'),
				'hasEvent' => $hasEvent
			];
		}

		return json_encode(['success' => true, 'data' => $array]);
	}

	public function actionGetEventDetail() {
		$event = Event::findOne(Yii::$app->request->post('id'));

		if ($event) {
			return json_encode(['success' => true, 'data' => [
					'user' => $event->user->attributes,
					'location' => $event->location,
					'title' => $event->title,
					'start_date' => $event->start_date,
					'end_date' => $event->end_date,
					'url' => $event->url,
					'notes' => $event->notes,
					'image' => $event->image,
					'region' => $event->region->name,
					'genre' => $event->genre->name
				]
			]);
		} else {
			return json_encode(['success' => false, 'data' => 'Event not found.']);
		}
	}

	public function actionUpgrade() {
		$user = User::findOne(Yii::$app->request->post('user_id'));

		if (!$user) {
			return json_encode(['success' => false, 'data' => ['User not found.']]);
		}

		$upgrade = new Upgrade();
		$upgrade->user_id = $user->id;
		$upgrade->phone_number = Yii::$app->request->post('phoneNumber');
		$upgrade->address = Yii::$app->request->post('address');
		$upgrade->about = Yii::$app->request->post('about');

		if ($upgrade->save()) {
			return json_encode(['success' => true, 'data' => '']);
		} else {
			return json_encode(['success' => false, 'data' => $upgrade->getErrors()]);
		}
	}

	/*public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

				return $this->goHome();
			} else {
				Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
			}
		}

		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->getSession()->setFlash('success', 'New password was saved.');

			return $this->goHome();
		}

		if(Yii::$app->request->isPost && $model->hasErrors()){
			Yii::$app->session->setFlash('error', $model->getErrors('password'));
		}

		return $this->render('resetPassword', [
			'model' => $model,
			'user' => Yii::$app->user->isGuest ? false : User::findOne(Yii::$app->user->id)
		]);
	}
	
	public function actionActivate($code){
		$user = User::findOne(['auth_key' => $code, 'status' => User::STATUS_NEW]);
		
		if ($user) {
			$user->status = User::STATUS_ACTIVE;
			$user->save();

			Yii::$app->getSession()->setFlash('success', 'Your account has been activated successfully.');

			//we only allow customer to register -> activate user should be customer also
			if (Yii::$app->user->login($user)) {

				if($user->empty_pwd){
					if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
						$user->generatePasswordResetToken();
						$user->save();
					}

					if($user->dealer){
						Yii::$app->language = $user->dealer->language;
	                	return $this->redirect(['reset-password', 'token' => $user->password_reset_token, 'language' => Yii::$app->language]);
	                } else {
						return $this->redirect(['reset-password', 'token' => $user->password_reset_token]);
					}
					
				} else {
					return $this->afterLogin();
				}

			}
		}    
	
		return $this->goHome();
	}*/

	/*public function afterLogin(){
		$user = User::findOne(Yii::$app->user->id);

		if($user){

			if($user->role >= User::ROLE_STAFF){
				return $this->redirect(['/admin']);
			}

			if($user->dealer){
				if(!empty($user->dealer->language)){
					Yii::$app->language = $user->dealer->language;
	                return $this->redirect(['/dealer', 'language' => Yii::$app->language]);
	            } else {
	            	return $this->redirect(['/dealer']);
	            }
			} else {
				return $this->redirect(['/customer']);
			}
		}
	}*/

}
