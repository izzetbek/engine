<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Training\Training;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\TrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trainings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Training', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered with-image'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'thumb',
                        'value' => function(Training $model) {
                            return  Html::img(Yii::getAlias('@frontendUpload/' . $model::SAVE_FOLDER . '/' . $model->thumb), ['height' => '100']);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'title',
                        'value' => 'translation.title',
                    ],
                    'price',
                    [
                        'attribute' => 'begin_date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'begin_date',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]),
                        'format' => 'datetime'
                    ],
                    [
                        'attribute' => 'draft',
                        'filter' => \core\helpers\FieldHelper::draftList(),
                        'value' => function(Training $model) {
                            return \core\helpers\FieldHelper::draftLabel($model->draft);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'backend\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
