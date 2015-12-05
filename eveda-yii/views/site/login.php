<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = Yii::t('app', 'Argonaut Online Tools | Fourth Element');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="full-width slideshow">

	<div class="cycle-slideshow"
		 data-cycle-fx="fade"
		 data-cycle-swipe="true"
		 data-cycle-swipe-fx="fade"
		 data-cycle-speed="1000"
		 data-cycle-timeout="6000"
		 data-cycle-prev=".cycle-next"
		 data-cycle-next=".cycle-prev"
		 data-cycle-slides="> div.slide">

		<div class="slide parallax" style="background: url(<?php echo Url::to('@web/img/banners/biomap-banner.jpg') ?>) no-repeat center top; background-size: cover;"></div>

		<!-- <span class="cycle-prev animated pulse"></span>
		<span class="cycle-next animated pulse"></span> -->

		<!-- <img src="/img/icons/icon-argo.svg" alt="#" class="motif"> -->

	</div>
	<!-- end slider -->

	<div class="full-width title-bar">
		<section class="content container">

			<div class="grid12 col">

				<img src="<?php echo Url::to('@web/img/icons/icon-argo.svg') ?>" alt="#" class="svg intro">

				<h1><?php echo Yii::t('app', 'Argonaut Online Tools') ?></h1>

				<h2><?php echo Yii::t('app', 'from Fourth Element') ?></h2>


			</div>
			<!-- end grid12 -->

		</section>
		<!--end of section-->
	</div>
	<!-- end of full width -->


</div><!--end of full width-->

<div class="full-width">
	<section class="content container">

		<div class="grid12 col"><?= Alert::widget() ?></div>

		<div class="grid3 col hide-mobile">&nbsp;</div>


		<div class="grid6 col box">

			<h3><?php echo Yii::t('app', 'Account Login') ?></h3>

			<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

			<div>
				<label for="username" class="description"><?php echo Yii::t('app', 'Email') ?></label>
				<?= Html::activeInput('text', $model, 'email', ['class' => 'email', 'maxlength' => '255', 'required' => true]) ?>
			</div>

			<div>
				<label for="password" class="description"><?php echo Yii::t('app', 'Password') ?></label>
				<?= Html::activeInput('password', $model, 'password', ['maxlength' => '255', 'required' => true]) ?>
			</div>

			<?= Html::input('submit', 'login', Yii::t('app', 'Login'), ['class' => 'button submit login']) ?>
			
			
			<?= Html::a(Yii::t('app', 'Forgot/Reset Password'), Url::to(['/site/request-password-reset']), ['class' => 'forgot-pwd-link']) ?>

			<?php ActiveForm::end(); ?>

		</div>
		<!-- end grid -->

		<div class="grid3 col hide-mobile">&nbsp;</div>

	</section>
	<!--end of section-->
</div><!-- end of full width -->