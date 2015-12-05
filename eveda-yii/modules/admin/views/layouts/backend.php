<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\BackendAsset;
use app\widgets\Alert;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
        BaseUrl = '<?php echo Url::to('@web/', true) ?>';
    </script>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Admin\'s Page',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            $menuItems = [
                ['label' => 'Admin', 'url' => ['/admin']],
            ];
            
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {

                $user = User::findOne(Yii::$app->user->id);
                if($user && $user->role >= User::ROLE_ADMIN){
                    $menuItems[] = ['label' => 'Staff', 'url' => ['/admin/staff']];
                }

                $menuItems[] = ['label' => 'User', 'url' => ['/admin/user']];
                $menuItems[] = ['label' => 'Upgrade', 'url' => ['/admin/upgrade']];

                $menuItems[] = ['label' => 'Events', 'url' => ['/admin/event']];
                $menuItems[] = ['label' => 'Public Events', 'url' => ['/admin/eventpost']];

                $menuItems[] = ['label' => 'Regions', 'url' => ['/admin/region']];
                $menuItems[] = ['label' => 'Genres', 'url' => ['/admin/genre']];
                
                $menuItems[] = ['label' => 'Logout', 'url' => ['/site/logout']];
            }

            echo Nav::widget([
                'options' => [
                    'class' => 'navbar-nav navbar-right',
                    'style' => 'margin-top: 7px;'
                ],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        </div>

        <div class="container">
            <br/>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Argonaut Online Tools | Fourth Element <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
