<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\EventPost;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\EventPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eventpost-form">

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
