<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style type="text/css">

    	/* ////////// Client Specific Styles ////////// */
    	#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
    	body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Helvetica, arial, sans-serif; background: #F6F6F6; }
    	/* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
    	.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
    	.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing. */
    	.backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
    	img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
    	a img {border:none;}
    	.image_fix {display:block;}
    	p {margin: 0px 0px !important;}
    	table td {border-collapse: collapse;}
    	table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
    	a {color: #29ABE2;text-decoration: none;text-decoration:none!important;}
    	a.cta { background-color: #29ABE2; padding: 10px; color: #FFFFFF; text-transform: uppercase; clear: both; float: none; }

    	/* ////////// Styles ////////// */

    	h3 { font-family: 'helvetica neue', Helvetica, arial, sans-serif; font-size: 18px; color: #333; text-align:left; line-height: 24px; font-weight: bold; margin: 0; padding: 0; margin-bottom: 10px !important; }
    	h4 { font-family: 'helvetica neue', Helvetica, arial, sans-serif; font-size: 16px; color: #333; text-align:left; line-height: 24px; font-weight: bold; margin: 0; padding: 0; margin-bottom: 10px !important; }
    	h5 { font-family: 'helvetica neue', Helvetica, arial, sans-serif; font-size: 14px; color: #333; text-align:left; line-height: 24px; font-weight: bold; margin: 0; padding: 0; margin-bottom: 10px !important; }
    	p  { font-family: 'helvetica neue', Helvetica, arial, sans-serif; font-size: 14px; color: #666; text-align:left; line-height: 24px; margin: 0; padding: 0; margin-bottom: 15px !important; }

    	ul li, ol li { font-size: 14px; color: #666; }
    	ul { list-style-type: disc; list-style-position: inside; margin-left: 0; padding-left: 0; }
    	ol { list-style-type: decimal; list-style-position: inside; margin-left: 0; padding-left: 0; }
    	ul ul, ol ul { list-style-type: circle; list-style-position: inside; margin-left: 0px; }
    	ol ol, ul ol { list-style-type: lower-latin; list-style-position: inside; margin-left: 0px; }
    	ul.toc { margin-bottom: 0; margin-left: 20px; }

    	td[class="padding-left-right10"] { padding-left: 0px !important; padding-right: 0px !important; }

    	td[class="show-mobile"] { display: none !important; }

    	table[class=full] { width: 100%; clear: both; }
    	table[class="cols2inner"] {width: 250px!important;}

    	td.language { font-family: Helvetica, arial, sans-serif; padding: 5px 7px !important; font-size: 10px; color: #899ba7; text-align:left; border: 1px solid #899ba7; text-align: center; }
    	td.language a { text-decoration: none !important; color: #899ba7; text-align: center; }
    	td.active { font-family: Helvetica, arial, sans-serif; color: #FFFFFF; background-color: #899ba7; border: 1px solid #899ba7; padding: 5px 7px !important; }
    	td.active a { color: #FFFFFF; font-size: 10px; }

    	td[class="intro-heading"] { font-family: Helvetica, arial, sans-serif; font-size: 22px; }
    	td[class="title"] { font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333; text-align:center; font-weight: bold; }
    	span[class="caption"] { font-family: Helvetica, arial, sans-serif; font-size: 12px; color: #666; text-align:left; }
    	table[class="toc2col"] { width: 50% !important; }

    	/* Info tables */
    	table.info-table { width: 100%; border: 1px solid #CCC; border-collapse:collapse; font-size: 12px; color: #666; margin-bottom: 10px; background-color: #FFFFFF; }
    	table.info-table th { padding: 5px; border: 1px solid #CCC; font-weight: bold; text-align: left; }
    	table.info-table td { padding: 5px; border: 1px solid #CCC; font-size: 12px;  }
    	table.info-table td a { color: #29ABE2; font-size: 12px; }

		table.info-table tr.total { border-top: 1px solid #333; }
		table.info-table tr.total td { font-weight: bold; border-top: 1px solid #333 !important; }

    	/* ////////// Tablet Styles ////////// */
    	@media only screen and (max-width: 640px) {
    		a[href^="tel"], a[href^="sms"] {
    			text-decoration: none;
    			color: #29ABE2; 
    			pointer-events: none;
    			cursor: default;
    		}
    		.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
    			text-decoration: default;
    			color: #29ABE2 !important;
    			pointer-events: auto;
    			cursor: default;
    		}
    		ul.toc { margin-left: 10px;}
    		td[class="intro-heading"] { font-family: Helvetica, arial, sans-serif; font-size: 18px; }
    		td[class="show-mobile"] { display: none !important; }
    		td[class="hide-mobile"] { display: block !important; }
    		td[class="hide-tablet-mobile"] { display: none !important; }
    		table[class=devicewidth] {width: 440px!important;text-align:center!important;}
    		table[class=devicewidthmob] {width: 420px!important;text-align:center!important;}
    		table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
    		table[class="margin-left20"]{margin-left:20px !important;}
    		table[class="margin-right20"]{margin-right:20px !important;}
    		img[class=banner] {width: 440px!important;height:157px!important;}
    		img[class=col2img] {width: 440px!important;height:330px!important;}
    		table[class="cols3inner"] {width: 100px!important;}
    		table[class="cols2inner"] {width: 200px!important;}
    		table[class="toc2col"] { width: 50% !important; }
    		table[class="col3img"] {width: 131px!important;}
    		img[class="col3img"] {width: 131px!important;height: 82px!important;}
    		table[class='removeMobile']{width:10px!important;}
    		img[class="blog"] {width: 420px!important;height: 162px!important;}
    		td[class="padding-top-right15"]{padding:15px 15px 0 0 !important;}
    		td[class="padding-top-left20"]{padding:20px 0 0 20px !important;}
    		td[class="padding-right15"]{padding-right:15px !important;}
    		td[class="padding-left20"]{padding-left:20px !important;}
    		td[class="padding-right20"]{padding-right:20px !important;}
    		td[class="padding-bottom-left20"]{padding-bottom:20px !important; padding-left:20px !important; }
    		td[class="padding-left-right10"] { padding-left: 0px !important; padding-right: 0px !important; }
    	}

    	/* ////////// Mobile Styles ////////// */
    	@media only screen and (max-width: 480px) {
    		a[href^="tel"], a[href^="sms"] {
    			text-decoration: none;
    			color: #29ABE2;
    			pointer-events: none;
    			cursor: default;
    		}
    		.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
    			text-decoration: default;
    			color: #29ABE2 !important; 
    			pointer-events: auto;
    			cursor: default;
    		}
    		td[class="intro-heading"] { font-family: Helvetica, arial, sans-serif; font-size: 16px; }
    		td[class="show-mobile"] { display: block !important; }
    		td[class="hide-mobile"] { display: none !important; }
    		td[class="hide-tablet-mobile"] { display: none !important; }
    		table[class=devicewidth] {width: 280px!important;text-align:center!important;}
    		table[class=devicewidthmob] {width: 260px!important;text-align:center!important;}
    		table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
    		table[class="margin-left20"]{margin-left:20px !important;}
    		table[class="margin-right20"]{margin-right:20px !important;}
    		img[class=banner] {width: 280px!important;height:100px!important;}
    		img[class=col2img] {width: 280px!important;height:210px!important;}
    		table[class="cols3inner"] {width: 260px!important;}
    		table[class="cols2inner"] {width: 260px!important;}
    		table[class="toc2col"] { width: 100% !important; }
    		img[class="col3img"] {width: 280px!important;height: 175px!important;}
    		table[class="col3img"] {width: 280px!important;}
    		img[class="blog"] {width: 260px!important;height: 100px!important;}
    		td[class="padding-top-right15"]{padding:15px 15px 0 0 !important;}
    		td[class="padding-top-left20"]{padding:20px 0 0 20px !important;}
    		td[class="padding-right15"]{padding-right:15px !important;}
    		td[class="padding-left20"]{padding-left:20px !important;}
    		td[class="padding-right20"]{padding-right:20px !important;}
    		td[class="padding-bottom-left20"]{padding-bottom:20px !important; padding-left:20px !important; }
    		td[class="padding-left-right10"] { padding-left: 10px !important; padding-right: 10px !important; }
    	}

		/* Order Status colors */
		h4.status { text-align: center; display: block; padding: 6px 12px; }
		h4.in-production { text-align: center; display: block; padding: 6px 12px; color: #FF9900; border: 1px solid #FF9900; }
		h4.quality-control { text-align: center; display: block; padding: 6px 12px; color: #CC0000; border: 1px solid #CC0000; }
		h4.dispatched { text-align: center; display: block; padding: 6px 12px; color: #339900; border: 1px solid #339900; }
    </style>
</head>
<body>
    <?php $this->beginBody() ?>

    <!-- Start of header 1 -->
	<table width="100%" bgcolor="#F6F6F6" cellpadding="0" cellspacing="0" border="0" class="backgroundTable">
	   <tbody>
	      <tr>
	         <td>
	            <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	               <tbody>
	                  <tr>
	                     <td width="100%">
	                        <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	                           <tbody>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td width="100%" height="30"></td>
	                              </tr>
	                           </tbody>
	                        </table>
	                     </td>
	                  </tr>
	               </tbody>
	            </table>
	         </td>
	      </tr>
	   </tbody>
	</table>
	<!-- End of header 1 --> 


	<!-- Start of header 2 -->
	<table width="100%" bgcolor="#F6F6F6" cellpadding="0" cellspacing="0" border="0" class="backgroundTable">
	   <tbody>
	      <tr>
	         <td>
	            <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	               <tbody>
	                  <tr>
	                     <td width="100%">
	                        <table bgcolor="#F6F6F6" width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	                           <tbody>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
	                              </tr>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td>
	                                    <!-- logo -->
	                                    <table width="120" align="left" border="0" cellpadding="0" cellspacing="0">
	                                       <tbody>
	                                          <tr>
	                                             <td width="20"></td>
	                                             <td width="100" height="49" align="left">
	                                                <div class="imgpop">
	                                                   <a target="_blank" name="Argonaut" href="<?php echo Url::to('/site/index', true) ?>">
	                                                   <img src="<?php echo Url::to('@web/img/mail/fe-argo-logo.png', true) ?>" alt="" border="0" width="160" height="40" style="display:block; border:none; outline:none; text-decoration:none;">
	                                                   </a>
	                                                </div>
	                                             </td>
	                                          </tr>
	                                       </tbody>
	                                    </table>
	                                    <!-- end of logo -->
	                                 </td>
	                                 <td>
	                                    <table width="120" align="right" border="0" cellpadding="0" cellspacing="0">
	                                       <tbody>
	                                          <tr>
	                                             <td width="120" height="49" align="right">
	                                                <a style="text-decoration: none; color: #FF6600; font-size: 12px; border: 1px solid #FF6600; padding: 10px 20px; text-align:center; text-transform: uppercase;" href="<?php echo Url::to(isset($admin) ? '/admin/default/login' : '/site/login', true) ?>"><?php echo Yii::t('app', 'Login') ?></a>
	                                             </td>
	                                          </tr>
	                                       </tbody>
	                                    </table>
	                                    <!-- end of logo -->
	                                 </td>
	                              </tr>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
	                              </tr>
	                              <!-- Spacing -->
	                           </tbody>
	                        </table>
	                     </td>
	                  </tr>
	               </tbody>
	            </table>
	         </td>
	      </tr>
	   </tbody>
	</table>
	<!-- End of Header 2 -->



	<!-- Start of banner image -->
	<table width="100%" bgcolor="#F6F6F6" cellpadding="0" cellspacing="0" border="0" class="backgroundTable" id="banner">
	   <tbody>
	      <tr>
	         <td>
	            <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	               <tbody>
	                  <tr>
	                     <td width="100%">
	                        <table width="560" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
	                           <tbody>
	                              <tr>
	                                 <!-- start of image -->
	                                 <td align="center">
	                                    <div class="imgpop">
	                                       <a target="_blank" href="#" name="bannerImage"><img width="560" border="0" height="200" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="<?php echo Url::to('@web/img/mail/banner.jpg', true) ?>" class="banner"></a>
	                                    </div>
	                                 </td>
	                              </tr>
	                           </tbody>
	                        </table>
	                        <!-- end of image -->
	                     </td>
	                  </tr>
	               </tbody>
	            </table>
	         </td>
	      </tr>
	   </tbody>
	</table>
	<!-- End of banner image -->

    <?= $content ?>
    
    <!-- Start of footer -->
	<table width="100%" bgcolor="#F6F6F6" cellpadding="0" cellspacing="0" border="0" class="backgroundTable">
	   <tbody>
	      <tr>
	         <td>
	            <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	               <tbody>
	                  <tr>
	                     <td width="100%">
	                        <table bgcolor="#F6F6F6" width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
	                           <tbody>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td width="100%" height="20"></td>
	                              </tr>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 11px; color: #999; text-align:center; padding-left: 20px; padding-right: 20px; ">
	                                    <?php echo Yii::t('app', "You've received this email because you have an Argonaut Online Tools account.  Please do not reply to this email, as we are not able to respond to messages sent to this address. If you have further questions or concerns, please email <a style='text-decoration: none; color: #CCC' href='mailto:{email}' name='EmailAddressFooter'>{email}</a>", [ 
                                            'email' => Yii::$app->params['supportEmail'] 
                                        ]) ?> 
	                                 </td>
	                              </tr>
	                              <!-- Spacing -->
	                              <tr>
	                                 <td width="100%" height="30"></td>
	                              </tr>
	                              <!-- Spacing -->
	                           </tbody>
	                        </table>
	                     </td>
	                  </tr>
	               </tbody>
	            </table>
	         </td>
	      </tr>
	   </tbody>
	</table>
	<!-- End of footer -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
