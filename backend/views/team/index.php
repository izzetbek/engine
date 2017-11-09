<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Team';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Teammate', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function (\core\entities\Site\Team\Team $model) {
                            return
                                Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id], ['data-method' => 'post']) .
                                Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id], ['data-method' => 'post']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'thumb',
                        'value' => function(\core\entities\Site\Team\Team $teammate) {
                            return  Html::img(Yii::getAlias('@frontendUpload/team/' . $teammate->thumb), ['height' => '100']);
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
                        'value' => function(\core\entities\Site\Team\Team $teammate) {
                            return \core\helpers\FieldHelper::draftLabel($teammate->draft);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'backend\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
