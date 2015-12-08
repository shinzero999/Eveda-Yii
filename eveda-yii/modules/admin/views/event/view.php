<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Event */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attributes' => 'user_id',
                'label' => 'Username',
                'value' => $model->user->display_name,
            ],
            //'user_id',
            'title',
            'location',
            'start_date',
            'end_date',
            'url:url',
            'notes',
            [
                'attribute' => 'image',
                'value' => '<img src="' . $model->image . '" style="height: 500px;"/>',
                'label' => 'Image',
                'format' => 'raw',
            ],
            [
                'attribute' => 'visibility',
                'value' => $model->visibility == 1 ? "Public" : "Private",
                'label' => 'Visibility',
            ],
            [
                'attribute' => 'region_id',
                'value' => $model->region->name,
                'label' => 'Region',
            ],
            [
                'attribute' => 'genre_id',
                'value' => $model->genre->name,
                'label' => 'Genre',
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
