<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Site\Partner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-view">

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
            'title',
            [
                'attribute' => 'thumb',
                'value' => function(\core\entities\Site\Partner $partner) {
                    return  Html::img(Yii::getAlias('@frontendUpload/partners/' . $partner->thumb), ['height' => '100']);
                },
                'format' => 'html'
            ],
            'link',
            [
                'attribute' => 'draft',
                'filter' => \core\helpers\FieldHelper::draftList(),
                'value' => function(\core\entities\Site\Partner $partner) {
                    return \core\helpers\FieldHelper::draftLabel($partner->draft);
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
