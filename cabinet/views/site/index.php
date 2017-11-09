<?php

/** @var $this yii\web\View */
/** @var $user \core\entities\User\User  */

use yii\helpers\Html;

$this->title = 'My Webinars';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <?= \yii\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $user->webinars
                ]),
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered with-image'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'translation.title',
                        'label' => 'Title',
                        'value' => function(\core\entities\Webinar\Webinar $webinar) {
                            return  Html::a($webinar->translation->title, ['site/view', 'id' => $webinar->id]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => \core\helpers\WebinarHelper::statusesList(),
                        'value' => function(\core\entities\Webinar\Webinar $webinar) {
                            return \core\helpers\WebinarHelper::statusLabel($webinar->status);
                        },
                        'format' => 'raw',
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>
