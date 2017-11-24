<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $question \core\entities\Cabinet\Question */
/** @var $answers array */
/** @var $model \core\forms\cabinet\AnswerForm */

$this->title = $question->title;
$this->params['breadcrumbs'][] = $this->title;

$questionClass = ($question->status == $question::STATUS_ANSWERED)? 'success' : 'warning';
?>
<div class="question-view">
    <div class="panel panel-<?= $questionClass ?> question">
        <div class="panel-heading">
            <h4 class="pull-left"><?= $question->title ?></h4>
            <? if ($question->isFrom(Yii::$app->user->id)): ?>
                <? if (!$question->isComplete()) { ?>
                    <?= Html::a('Close Ticket', ['question/complete', 'id' => $question->id], ['class' => 'btn btn-lg btn-success pull-right']) ?>
                <? } else { ?>
                    <?= Html::a('Open Ticket', ['question/open', 'id' => $question->id], ['class' => 'btn btn-lg btn-warning pull-right']) ?>
                <? } ?>
            <? endif; ?>
            <br clear="both">
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
        <?php $form = ActiveForm::begin([
            'action' => \yii\helpers\Url::toRoute(['comment/add', 'id' => $question->id])
        ]); ?>

        <?= $form->field($model, 'content')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton('Comment', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>