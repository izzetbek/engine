<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Document\DocumentForm */
/* @var $form yii\widgets\ActiveForm */

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
$additionalOptions = [];
if ($model->file) {
    $additionalOptions = [
        'initialPreviewConfig' => [
            ['url' => \yii\helpers\Url::toRoute(['template/delete-thumb','id' => $model->getId()])],
        ],
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
    ];
    $previewOptions = \yii\helpers\ArrayHelper::merge($model->getPreviewOpts(), $additionalOptions);
    $thumbOptions = \yii\helpers\ArrayHelper::merge($thumbOptions, $previewOptions);
}
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">

            <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                'fields' => [
                    ['title', 'text', ['maxlength' => true]],
                ]
            ])->label(false) ?>

        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">General</h3>
                </div>
                <div class="box-body">

                    <?= $form->field($model, 'textFile')->widget(\kartik\widgets\FileInput::className(), [
                        'pluginOptions' => $thumbOptions,
                        'options' => ['accept' => 'application/msword,application/pdf']
                    ]); ?>

                    <?= $form->field($model, 'order')->widget(\kartik\widgets\TouchSpin::className()); ?>

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
    </div>

    <?php ActiveForm::end(); ?>

</div>
