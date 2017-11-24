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

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
$additionalOptions = [];
if ($model->thumb) {
    $additionalOptions = [
        'initialPreview' => Yii::getAlias('@frontendUpload/articles/' . $model->thumb),
        'initialPreviewConfig' => [
            ['url' => \yii\helpers\Url::toRoute(['article/delete-thumb','id' => $user->id])],
        ],
        'initialPreviewAsData'=>true,
        'overwriteInitial' => true,
    ];
}
?>
<div class="user-update">
    <?php $form = ActiveForm::begin (); ?>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-body">
                    <?= $form->field($model, 'imageFile')->widget(\kartik\widgets\FileInput::className(), [
                        'pluginOptions' => \yii\helpers\ArrayHelper::merge($thumbOptions, $additionalOptions),
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
