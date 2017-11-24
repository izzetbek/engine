<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\entities\User\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
?>
<div class="user-create">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['maxLength' => true]); ?>

                            <?= $form->field($model, 'surname')->textInput(['maxLength' => true]); ?>

                            <?= $form->field($model, 'company')->textInput(['maxLength' => true]); ?>

                            <?= $form->field($model, 'phone')->textInput(['maxLength' => true]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'username')->textInput(['maxLength' => true]); ?>

                            <?= $form->field($model, 'email')->textInput(['maxLength' => true]); ?>

                            <?= $form->field($model, 'password')->passwordInput(['maxLength' => true]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-body">
                    <?= $form->field($model, 'imageFile')->widget(\kartik\widgets\FileInput::className(), [
                        'pluginOptions' => $thumbOptions,
                        'options' => ['accept' => 'image/*']
                    ]); ?>

                    <?= $form->field($model, 'role')->dropDownList(\core\helpers\UserHelper::rolesList()) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>