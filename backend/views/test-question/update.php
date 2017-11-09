<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use common\widgets\MultilingualFormInputs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\OnlineTest\Question\QuestionForm */
/* @var $additional boolean */

$this->title = 'Update Question: ' . $model->getId();
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getId(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">

    <div class="question-form">

        <?php $form = ActiveForm::begin(['id' => 'test-question-form', 'action' => Url::toRoute(['test-question/update', 'id' => $model->getId()])]) ?>

        <div class="row">

            <div class="col-md-9">

                <div class="question">
                    <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(MultilingualFormInputs::className(), [
                        'fields' => [
                            ['title', 'textarea', ['maxlength' => true]],
                        ]
                    ])->label(false) ?>
                </div>

                <div class="variants">
                    <? if ($additional): ?>
                        <input type="hidden" name="additional" value="true">
                    <? endif; ?>
                    <button type="button"
                            class="pull-right add-item btn btn-success btn-xs"
                            data-action="<?= Url::toRoute(['test-question/add-variant', 'id' => $model->getId()]) ?>"
                            id="add-variant"
                    >
                        <i class="fa fa-plus"></i> Add variant
                    </button>
                    <br clear="both">
                    <div class="row container-items">
                        <? foreach ($model->variants as $i => $variant): ?>
                            <div class="col-md-6 item">
                                <div class="box <?= ($variant->correct)? 'box-success' : '' ?>">
                                    <div class="box-body">
                                        <table width="100%">
                                            <tr>
                                                <td width="90%">
                                                    <?= $form->field($variant, 'translations')->widget(MultilingualFormInputs::className(), [
                                                        'fields' => [
                                                            ['content', 'text', ['maxlength' => true]],
                                                        ],
                                                        'minimized' => true,
                                                    ])->label(false) ?>
                                                </td>
                                                <td align="center" valign="center">
                                                    <?= $form->field($variant, "correct")->checkbox(['label' => null, 'class' => 'is_correct'])->label(false) ?>
                                                    <button type="button"
                                                            class="pull-right remove-item btn btn-danger btn-xs"
                                                            data-action="<?= Url::toRoute(['test-question/remove-variant', 'id' => $variant->getId()]) ?>"
                                                    >
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>

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

                        <div class="form-group"><?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?></div>

                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
