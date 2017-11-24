<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Vacancy\VacancyForm */
/* @var $vacancy \core\entities\Vacancy\Vacancy */

$this->title = 'Update Vacancy: ' . $vacancy->translation->title;
$this->params['breadcrumbs'][] = ['label' => 'Vacancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $vacancy->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="vacancy-update">

    <div class="vacancy-form">

        <div class="row">

            <?php $form = ActiveForm::begin(); ?>

            <div class="col-sm-9">

                <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                    'fields' => [
                        ['title', 'text', ['maxlength' => true]],
                        ['location', 'text', ['maxlength' => true]],
                        ['description', 'editor'],
                    ]
                ])->label(false) ?>

            </div>

            <div class="col-sm-3">

                <div class="box box-warning">

                    <div class="box-header with-border">
                        <h3 class="box-title">General</h3>
                    </div>

                    <div class="box-body">
                        <?= $form->field($model, 'userId')->widget(Select2::className(), [
                            'initValueText' => $vacancy->user->company,
                            'options' => ['placeholder' => 'Search for a company ...'],
                            'pluginOptions' => [
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => \yii\helpers\Url::to(['user/company-list']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(user) { return user.company; }'),
                                'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                            ]
                        ]) ?>

                        <?= DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'startDate',
                            'attribute2' => 'endDate',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]); ?>

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

</div>