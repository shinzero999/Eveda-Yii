<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eventpost-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'event_id',
                'label' => 'Event Title',
                'value' => 'event.title'
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($data) {
                    return '<span class="label label-' . $data->statusColor . '">' . $data->statusName . '</span>';
                },
                'headerOptions' => ['style' => 'width: 70px'],
            ],
            'message',
            [
                'attribute' => 'event.start_date',
                'label' => 'Start Date',
            ],
            [
                'attribute' => 'event.end_date',
                'label' => 'End Date',
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
