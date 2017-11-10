<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Site\Banner;
use core\helpers\FieldHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'value' => function (Banner $model) {
                            return
                                Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id], ['data-method' => 'post']) .
                                Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id], ['data-method' => 'post']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'thumb',
                        'value' => function(Banner $model) {
                            return  Html::img(Yii::getAlias('@frontendUpload/banners/' . $model->thumb), ['height' => '100']);
                        },
                        'format' => 'html'
                    ],
                    'link',
                    [
                        'attribute' => 'draft',
                        'filter' => FieldHelper::draftList(),
                        'value' => function(Banner $banner) {
                            return FieldHelper::draftLabel($banner->draft);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'backend\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
