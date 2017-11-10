<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'userId',
                        'value' => 'user.username'
                    ],
                    [
                        'attribute' => 'webinarId',
                        'value' => 'webinar.translation.title'
                    ],
                    [
                        'attribute' => 'ask_date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'ask_date',
                            'value' => 'ask_date',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]),
                        'format' => 'datetime'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => \core\helpers\QuestionHelper::statusesList(),
                        'value' => function(\core\entities\Cabinet\Question $question) {
                            return \core\helpers\QuestionHelper::statusLabel($question->status);
                        },
                        'format' => 'raw',
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
