<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Cabinet\AnswerForm */
/* @var $question core\entities\Cabinet\Question */

$this->title = 'Update Question For: ' . $question->webinar->translation->title;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $question->id, 'url' => ['view', 'id' => $question->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">

    <div class="question">
        <div class="user-block">
            <img src="/images/user.png" class="img-circle img-bordered-sm" alt="user">
            <span class="username"><?= $question->user->username ?></span>
            <span class="description"><?= Yii::$app->formatter->asDate($question->ask_date) ?></span>
        </div>
        <blockquote>
            <p><?= $question->question ?></p>
        </blockquote>
    </div>
    <? if ($question->answer): ?>
        <div class="question">
            <div class="user-block">
                <img src="/images/admin.png" class="img-circle img-bordered-sm" alt="admin">
                <span class="username">Administrator</span>
            </div>
            <blockquote>
                <p><?= $question->answer ?></p>
            </blockquote>
        </div>
    <? endif; ?>

    <div class="question-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Answer', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>