<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Upgrade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="upgrade-form">

    <?= DetailView::widget([
        'model' => $upgrade,
        'attributes' => [
            //'id',
            [
                'attribute' => 'user_id',
                'value' => $upgrade->user->display_name,
                'label' => 'Username',
            ],
            [
                'attribute' => 'user_id',
                'value' => $upgrade->user->email,
                'label' => 'Email',
            ],
            //'user_id',
            'phone_number',
            'address',
            'about',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'role')->dropdownList(User::$rolesForUser) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
