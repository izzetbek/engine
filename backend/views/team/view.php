<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Site\Team\Team */

$this->title = $model->translation->name;
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'thumb',
                'value' => function(\core\entities\Site\Team\Team $teammate) {
                    return  Html::img(Yii::getAlias('@frontendUpload/team/' . $teammate->thumb), ['height' => '100']);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'draft',
                'filter' => \core\helpers\FieldHelper::draftList(),
                'value' => function(\core\entities\Site\Team\Team $teammate) {
                    return \core\helpers\FieldHelper::draftLabel($teammate->draft);
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
