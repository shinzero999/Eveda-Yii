<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UpgradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upgrades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upgrade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Upgrade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'value' => 'user.display_name',
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Role',
                'value' => 'user.roleName',
            ],
            'phone_number',
            'address',
            'about',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
