<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use core\entities\User\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'created_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
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
                        'filter' => \core\helpers\UserHelper::statusesList(),
                        'value' => function(\core\entities\User\User $user) {
                            return \core\helpers\UserHelper::statusLabel($user->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'filter' => \core\helpers\UserHelper::rolesList(),
                        'value' => function(\core\entities\User\User $user) {
                            return \core\helpers\UserHelper::roleLabel($user->role);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{activate} {deactivate} {update} {view} {delete}',
                        'buttons' => [
                            'deactivate' => function ($url, User $model) {
                                return $model->isActive() ? Html::a('<span class="glyphicon glyphicon glyphicon-thumbs-down"></span>', $url, [
                                    'title' => 'Deactivate',
                                ]) : '';
                            },
                            'activate' => function ($url, User $model) {
                                return $model->isWait() ? Html::a('<span class="glyphicon glyphicon glyphicon-thumbs-up"></span>', $url, [
                                    'title' => 'Activate',
                                ]) : '';
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
