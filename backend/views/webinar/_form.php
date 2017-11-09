<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Webinar\Webinar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                'fields' => [
                    ['title', 'text', ['maxlength' => true]],
                    ['siteDescription', 'editor'],
                    ['cabinetDescription', 'editor'],
                ]
            ])->label(false) ?>
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">General</h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'price')->widget(\kartik\money\MaskMoney::className(), [
                        'pluginOptions' => [
                            'prefix' => 'AZN ',
                            'allowNegative' => false,
                        ]
                    ]) ?>

                    <?= $form->field($model, 'beginDate')->widget(\kartik\widgets\DateTimePicker::className(), [

                    ]) ?>

                    <?= $form->field($model, 'status')->dropDownList(\core\helpers\WebinarHelper::statusesList()) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
