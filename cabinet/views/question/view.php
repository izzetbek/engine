<?php

/** @var $this yii\web\View */
/** @var $question \core\entities\Cabinet\Question */

$this->title = $question->webinar->translation->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">
    <div class="body-heading">
        <h3><?= $question->webinar->translation->title ?></h3>
    </div>
    <div class="body-content">
        <div class="row">
            <?= $question->question ?>
            <hr>
            <?= $question->answer ?>
        </div>
    </div>
</div>
