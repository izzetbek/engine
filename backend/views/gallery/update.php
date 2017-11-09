<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Gallery\AlbumForm */

$this->title = 'Update Album: ' . $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['view', 'id' => $model->getName()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="album-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
