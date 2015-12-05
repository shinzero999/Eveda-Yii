<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\User;

use app\assets\AppAsset;
use app\assets\AppAssetEndBody;
use app\assets\AppConditionAssetForIE;
use app\assets\AppConditionAssetForIE8;
use app\assets\AppConditionAssetForIE7;
use app\assets\BackendOrderAsset;

use app\models\LoginForm;
use app\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AppAssetEndBody::register($this);
AppConditionAssetForIE::register($this);
AppConditionAssetForIE8::register($this);
AppConditionAssetForIE7::register($this);
BackendOrderAsset::register($this);
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

	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="page-wrap">

	<div id="head" class="full-width">
		<section id="header" class="container">

			<a href="<?php echo Url::home() ?>" class="logo"></a>

			<nav id="menu">
				<ul>
					<?php
					$menuItems = [
		                ['label' => 'Admin', 'url' => ['/admin']],
		            ];
		            
		            if (Yii::$app->user->isGuest) {
		                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'], 'class' => 'login'];
		            } else {

		                $user = User::findOne(Yii::$app->user->id);
		                if($user && $user->role >= User::ROLE_ADMIN){
		                    $menuItems[] = ['label' => 'Staff', 'url' => ['/admin/user']];
		                }

		                if($user && $user->role >= User::ROLE_STAFF){
		                    $menuItems[] = ['label' => 'Customers', 'url' => ['/admin/customer']];
		                }
		                
		                $menuItems[] = ['label' => 'Dealers', 'url' => ['/admin/dealer']];
		                $menuItems[] = ['label' => 'Orders', 'url' => ['/admin/order']];

		                if($user && $user->role >= User::ROLE_STAFF){
		                    $menuItems[] = ['label' => 'Prices', 'url' => ['/admin/price']];
		                }
		                
		                $menuItems[] = ['label' => 'Logout', 'url' => ['/site/logout'], 'class' => 'active'];
		            }
		            ?>
		            <?php foreach ($menuItems as $key => $menu) : ?>
            			<li class="<?= isset($menu['class'])?$menu['class']:'' ?>"><a href="<?php echo Url::to($menu['url']) ?>"><?= $menu['label'] ?></a>
						</li>
            		<?php endforeach ?>

				</ul>
			</nav>

		</section>
	</div>
	<!--end of full width-->

	<?= $content ?>

	<a href="#top" id="top-link"><span></span></a>

</div>
<!-- end of page-wrap -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
