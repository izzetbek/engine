<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\entities\User\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    'created_at:datetime',
                    [
                        'attribute' => 'status',
                        'value' => function(\core\entities\User\User $user) {
                            return \core\helpers\UserHelper::statusLabel($user->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'value' => function(\core\entities\User\User $user) {
                            return \core\helpers\UserHelper::roleLabel($user->role);
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
