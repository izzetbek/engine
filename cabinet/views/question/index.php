<?php

/** @var $this yii\web\View */
/** @var $questions \core\entities\Cabinet\Question[]  */

use yii\helpers\Html;

$this->title = 'My questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">
    <div class="body-content">
        <div class="row">
            <?= \yii\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $questions
                ]),
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered with-image'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'webinar.translation.title',
                        'label' => 'Title',
                        'value' => function(\core\entities\Cabinet\Question $question) {
                            return  Html::a($question->webinar->translation->title, ['question/view', 'id' => $question->id]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'ask_date',
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => \core\helpers\QuestionHelper::statusesList(),
                        'value' => function(\core\entities\Cabinet\Question $question) {
                            return \core\helpers\QuestionHelper::statusLabel($question->status);
                        },
                        'format' => 'raw',
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>
