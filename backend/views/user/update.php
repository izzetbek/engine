<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $model \core\forms\manager\User\UserEditForm */

$this->title = 'Update User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxLength' => true]); ?>
    <?= $form->field($model, 'email')->textInput(['maxLength' => true]); ?>
    <?= $form->field($model, 'role')->dropDownList(\core\helpers\UserHelper::rolesList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
