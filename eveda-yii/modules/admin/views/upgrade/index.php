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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'label' => 'Email',
                'value' => 'user.email',
                'format' => 'email'
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Role',
                'value' => 'user.roleName',
            ],
            'phone_number',
            'address',
            //'about',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['style' => 'width: 70px'],
            ],
        ],
    ]); ?>

</div>
