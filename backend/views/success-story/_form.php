<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\SuccessStory\StoryForm */
/* @var $form yii\widgets\ActiveForm */

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
$additionalOptions = [];
if ($model->thumb) {
    $additionalOptions = [
        'initialPreview' => Yii::getAlias('@frontendUpload/stories/' . $model->thumb),
        'initialPreviewConfig' => [
            ['url' => \yii\helpers\Url::toRoute(['partner/delete-thumb','id' => $model->getId()])],
        ],
        'initialPreviewAsData'=>true,
        'overwriteInitial' => true,
    ];
}
?>

<div class="success-story-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">

            <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                'fields' => [
                    ['name', 'text', ['maxlength' => true]],
                    ['position', 'text'],
                    ['story', 'editor'],
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

                    <?= $form->field($model, 'company')->textInput(); ?>

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
