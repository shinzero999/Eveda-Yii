<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'value' => 'user.display_name'
            ],
            'title',
            'location',
            'start_date',
            'end_date',
            // 'url:url',
            // 'notes',
            // 'image',
            [
                'attribute' => 'visibility',
                'label' => 'Visibility',
                'value' => function($data) {
                    return $data->visibility == 1 ? "Public" : "Private";
                }
            ],
            [
                'attribute' => 'region_id',
                'label' => 'Region',
                'value' => 'region.name'
            ],
            // 'genre_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
