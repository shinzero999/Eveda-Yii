<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\AppAssetEndBody;
use app\assets\AppConditionAssetForIE;
use app\assets\AppConditionAssetForIE8;
use app\assets\AppConditionAssetForIE7;

use app\models\LoginForm;
use app\widgets\Alert;
use app\widgets\LangSwitch;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AppAssetEndBody::register($this);
AppConditionAssetForIE::register($this);
AppConditionAssetForIE8::register($this);
AppConditionAssetForIE7::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js loading ie6 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 7]>
<html class="no-js loading ie7 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 8]>
<html class="no-js loading ie8 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js loading" dir="ltr" lang="<?= Yii::$app->language ?>"> <!--<![endif]-->
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<link rel="shortcut icon" href="<?php echo Yii::$app->homeUrl; ?>favicon.ico" type="image/x-icon"/>
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<script type="text/javascript">
		BaseUrl = '<?php echo Url::to('@web/', true) ?>';
	</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-69151500-1', 'auto');
  ga('send', 'pageview');

</script>

	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="mobile-nav">
	<a href="javascript:;" class="close-mobile-nav"></a>

	<ul class="accordion">
		<li><a href="<?php echo Url::home() ?>"><?php echo Yii::t('app', 'Home') ?></a></li>
	</ul>

</div>
<!-- end mobile nav -->

<div id="page-wrap">

	<div id="head" class="full-width">
		<section id="header" class="container">

			<!-- <div id="login-box">
				<h4>ACCOUNT LOGIN</h4>
				<span><input id="user-name" type="text" value="Username" onfocus="this.value=''"/></span>
				<span><input id="password" type="text" value="*********" onfocus="this.value=''"/></span>
				<span class="submit"><input class="btn" type="login" name="login" value="Sign In" /></span>
				<a href="#">Forgot Your Password?</a>
			</div> -->

			<span id="switch" class="open-mobile-nav">&#8801;</span>

			<a href="<?php echo Url::home() ?>" class="logo"></a>


		</section>
	</div>
	<!--end of full width-->

	<?= $content ?>

	<a href="#top" id="top-link"><span></span></a>

	<!-- Hidden Inline Content -->
	<div style="display: none;">

		<div id="inline-test" class="inline">

		</div>
	</div>
	<!-- end inline content -->

</div>
<!-- end of page-wrap -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
