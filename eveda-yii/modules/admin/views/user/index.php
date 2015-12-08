<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'display_name',
            'email:email',
            [
                'attribute' => 'role',
                'label' => 'Role',
                'value' => 'roleName',
            ],
            /*[
                'attribute' => 'eventsCount',
                'label' => 'Public events count',
            ],*/
            //'auth_key',
            //'password_hash',
            // 'password_reset_token',
            // 'empty_pwd',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($data) {
                    return '<span class="label label-' . $data->statusColor . '">' . $data->statusName . '</span>';
                },
                'headerOptions' => ['style' => 'width: 70px'],
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>

</div>
