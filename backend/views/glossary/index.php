<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\GlossarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Glossaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="glossary-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Glossary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'title',
                        'value' => 'translation.title'
                    ],
                    [
                        'attribute' => 'draft',
                        'filter' => \core\helpers\FieldHelper::draftList(),
                        'value' => function(\core\entities\Site\Glossary\Glossary $glossary) {
                            return \core\helpers\FieldHelper::draftLabel($glossary->draft);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'backend\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
