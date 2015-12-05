<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = Yii::t('app', $name);
?>
<div class="full-width fixed-banner diver1" data-type="background" data-speed="10">
	
	<div class="full-width title-bar ">	
	<section class="content container">
		<div class="grid12 col">
		</div><!-- end grid12 -->	
	</section><!--end of section-->
</div><!-- end of full width -->


</div><!--end banner-->

		
<div class="full-width center">		
	<section class="content container">

		<div class="grid12 col">

			<h1><?php echo Yii::t('app', '404: Page Not Found') ?></h1>
			<h3><?php echo Yii::t('app', "Sorry the page you were looking for can't be found.  Please use the navigation above.") ?></h3>

			<br/><br/><br/><br/><br/>
			
		</div><!-- end grid12 -->	

	</section><!--end of section-->
</div><!-- end of full width -->