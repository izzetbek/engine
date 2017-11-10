<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use core\entities\OnlineTest\Test\OnlineTest;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\OnlineTestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Online Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="online-test-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Online Test', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(OnlineTest $test) {
                            return  Html::img(Yii::getAlias('@frontendUpload/onlineTests/' . $test->thumb), ['height' => '100']);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'title',
                        'value' => 'translation.title',
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]),
                        'format' => 'datetime'
                    ],
                    'passed_by',
                    [
                        'attribute' => 'status',
                        'filter' => \core\helpers\OnlineTestHelper::statusesList(),
                        'value' => function(OnlineTest $test) {
                            return \core\helpers\OnlineTestHelper::statusLabel($test->status);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
