<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Training\TrainingForm */
/* @var $form yii\widgets\ActiveForm */

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
$additionalOptions = [];
if ($model->thumb) {
    $additionalOptions = [
        'initialPreview' => Yii::getAlias('@frontendUpload/trainings/' . $model->thumb),
        'initialPreviewConfig' => [
            ['url' => \yii\helpers\Url::toRoute(['article/delete-thumb','id' => $model->getId()])],
        ],
        'initialPreviewAsData'=>true,
        'overwriteInitial' => true,
    ];
}
?>

<div class="training-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-9">
        <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
            'fields' => [
                ['title', 'text', ['maxlength' => true]],
                ['description', 'editor'],
            ]
        ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">General</h3>
            </div>
            <div class="box-body">

                <?= $form->field($model, 'imageFile')->widget(\kartik\widgets\FileInput::className(), [
                    'pluginOptions' => \yii\helpers\ArrayHelper::merge($thumbOptions, $additionalOptions),
                    'options' => ['accept' => 'image/*']
                ]); ?>

                <?= $form->field($model, 'price')->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'prefix' => 'AZN ',
                        'allowNegative' => false,
                    ]
                ]) ?>

                <?= $form->field($model, 'beginDate')->widget(\kartik\widgets\DateTimePicker::className(), [

                ]) ?>

                <?= $form->field($model, 'draft')->widget(SwitchInput::classname(), [
                    'pluginOptions' => [
                        'onText' => 'active',
                        'offText' => 'inactive',
                        'onColor' => 'success',
                    ]
                ]); ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <br clear="both">

    <?php ActiveForm::end(); ?>

</div>
