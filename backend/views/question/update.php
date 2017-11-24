<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $question \core\entities\Cabinet\Question */
/** @var $answers array */
/** @var $model \core\forms\cabinet\AnswerForm */

$this->title = "Solve question: " . $question->title;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $question->title, 'url' => ['view', 'id' => $question->id]];
$this->params['breadcrumbs'][] = 'Update';


$questionClass = ($question->status == $question::STATUS_ANSWERED)? 'success' : 'warning';
?>
<div class="question-view">
    <div class="panel panel-<?= $questionClass ?> question">
        <div class="panel-heading">
            <h4><?= $question->title ?></h4>
        </div>
        <div class="panel-body">
            <?= $question->question ?>
        </div>
    </div>
    <hr>
    <div class="answers">
        <?= \common\widgets\TreeComment::widget([
            'data' => $answers,
            'commentForm' => $model
        ]) ?>
    </div>
    <hr>
    <div class="add-comment">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 10]) ?>

        <div class="form-group">
            <?= Html::submitButton('Comment', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>