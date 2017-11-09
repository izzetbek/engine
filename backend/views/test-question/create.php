<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use common\widgets\MultilingualFormInputs;
//use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\OnlineTest\Question\QuestionForm */

$this->title = 'Create Question';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <div class="question-form">

        <?php $form = ActiveForm::begin(['id' => 'test-question-form']); ?>

        <div class="row">

            <div class="col-md-9">

                <div class="question">
                    <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(MultilingualFormInputs::className(), [
                        'fields' => [
                            ['title', 'textarea', ['maxlength' => true]],
                        ]
                    ])->label(false) ?>
                </div>

            </div>

            <div class="col-md-3">

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">General</h3>
                    </div>
                    <div class="box-body">

                        <?= $form->field($model, 'testId')->dropDownList(\core\helpers\OnlineTestHelper::testList()) ?>

                        <?= $form->field($model, 'order')->widget(\kartik\widgets\TouchSpin::className()); ?>

                        <div class="form-group"><?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?></div>

                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php
/*
$form->field($model, 'variants')->widget(\common\widgets\DynamicForm::className(), [
    'fields' => [
        ['correct', 'checkbox']
    ],
    'translatable' => true,
    'translatableFields' => [
        ['content', 'text']
    ]
])
<?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $model->variants[0],
                        'formId' => 'test-question-form',
                        'formFields' => [
                            'correct',
                        ],
                    ]); ?>
<?php DynamicFormWidget::end(); ?>
*/