<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Site\HRTemplate\Template;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'value' => function (Template $model) {
                    return
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id], ['data-method' => 'post']) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id], ['data-method' => 'post']);
                },
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'title',
                'value' => 'translation.title',
            ],
            [
                'attribute' => 'draft',
                'filter' => \core\helpers\FieldHelper::draftList(),
                'value' => function(Template $model) {
                    return \core\helpers\FieldHelper::draftLabel($model->draft);
                },
                'format' => 'raw',
            ],

            ['class' => 'backend\grid\ActionColumn'],
        ],
    ]); ?>
</div>
