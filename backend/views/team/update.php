<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Team\TeamForm */

$this->title = 'Update Teammate: ' . $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';

$thumbOptions = [
    'showCaption' => false,
    'showUpload' => false,
    'showRemove' => false,
];
$additionalOptions = [];
if ($model->thumb) {
    $additionalOptions = [
        'initialPreview' => Yii::getAlias('@frontendUpload/team/' . $model->thumb),
        'initialPreviewConfig' => [
            ['url' => \yii\helpers\Url::toRoute(['partner/delete-thumb','id' => $model->getId()])],
        ],
        'initialPreviewAsData'=>true,
        'overwriteInitial' => true,
    ];
}
?>
<div class="team-update">

    <div class="team-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-9">

                <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                    'fields' => [
                        ['name', 'text', ['maxlength' => true]],
                        ['position', 'text'],
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

                        <?= $form->field($model, 'order')->widget(\kartik\widgets\TouchSpin::className()); ?>

                        <?= $form->field($model, 'draft')->widget(SwitchInput::classname(), [
                            'pluginOptions' => [
                                'onText' => 'active',
                                'offText' => 'inactive',
                                'onColor' => 'success',
                            ]
                        ]); ?>

                        <div class="form-group">
                            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>