<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Site\SuccessStory\SuccessStory;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\StorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Success Stories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="success-story-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Success Story', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'value' => function (SuccessStory $model) {
                    return
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id], ['data-method' => 'post']) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id], ['data-method' => 'post']);
                },
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'thumb',
                'value' => function(SuccessStory $story) {
                    return  Html::img(Yii::getAlias('@frontendUpload/stories/' . $story->thumb), ['height' => '100']);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'name',
                'value' => 'translation.name',
            ],
            [
                'attribute' => 'draft',
                'filter' => \core\helpers\FieldHelper::draftList(),
                'value' => function(SuccessStory $story) {
                    return \core\helpers\FieldHelper::draftLabel($story->draft);
                },
                'format' => 'raw',
            ],

            ['class' => 'backend\grid\ActionColumn'],
        ],
    ]); ?>
</div>
