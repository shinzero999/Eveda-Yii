<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\EventPost;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\EventPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eventpost-form">

    <?= DetailView::widget([
        'model' => $event,
        'attributes' => [
            //'id',
            [
                'attribute' => 'Username',
                'value' => $event->user->display_name,
                'label' => 'Username',
            ],
            'title',
            'location',
            'start_date',
            'end_date',
            'url:url',
            'notes',
            'image',
            [
                'attribute' => 'visibility',
                'value' => $event->visibility == 1 ? "Public" : "Private",
                'label' => 'Visibility',
            ],
            [
                'attribute' => 'region_id',
                'value' => $event->region->name,
                'label' => 'Region',
            ],
            [
                'attribute' => 'genre_id',
                'value' => $event->genre->name,
                'label' => 'Genre',
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->dropdownList(EventPost::$status) ?>
        </div>
    </div>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
