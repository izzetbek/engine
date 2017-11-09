<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model core\entities\OnlineTest\Test\OnlineTest */

$this->title = 'Create Online Test';
$this->params['breadcrumbs'][] = ['label' => 'Online Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="online-test-create">

    <div class="online-test-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">

            <div class="col-md-9">

                <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                    'fields' => [
                        ['title', 'text', ['maxlength' => true]],
                        ['description', 'editor'],
                    ],
                ])->label(false) ?>

            </div>

            <div class="col-md-3">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">General</h3>
                    </div>
                    <div class="box-body">
                        <?= $form->field($model, 'imageFile')->widget(\kartik\widgets\FileInput::className(), [
                            'pluginOptions' => [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                            ],
                            'options' => ['accept' => 'image/*']
                        ]); ?>

                        <?= $form->field($model, 'price')->widget(\kartik\money\MaskMoney::className(), [
                            'pluginOptions' => [
                                'prefix' => 'AZN ',
                                'allowNegative' => false,
                            ]
                        ]) ?>

                        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                            'pluginOptions' => [
                                'onText' => 'active',
                                'offText' => 'inactive',
                                'onColor' => 'success',
                            ]
                        ]); ?>

                        <div class="form-group"><?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?></div>
                    </div>
                </div>
            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
