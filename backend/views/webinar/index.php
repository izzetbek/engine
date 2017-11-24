<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use core\entities\Webinar\Webinar;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\WebinarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webinars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webinar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'thumb',
                        'value' => function(Webinar $model) {
                            return  Html::img(Yii::getAlias('@frontendUpload/' . $model::SAVE_FOLDER . '/' . $model->thumb), ['height' => '100']);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'title',
                        'value' => 'translation.title'
                    ],
                    'price',
                    [
                        'attribute' => 'beginDate',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'beginDate',
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
                        'filter' => \core\helpers\WebinarHelper::statusesList(),
                        'value' => function(\core\entities\Webinar\Webinar $webinar) {
                            return \core\helpers\WebinarHelper::statusLabel($webinar->status);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
