<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Category\CategoryForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <div class="row">
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

                    <?= $form->field($model, 'parentId')->dropDownList($model->parentCategoriesList()) ?>

                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'draft')->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'active',
                            'offText' => 'inactive',
                            'onColor' => 'success',
                        ]
                    ]); ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord() ? 'Create' : 'Update', ['class' => $model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                </div>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>