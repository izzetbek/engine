<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\BannerForm */

$this->title = 'Update Banner: ' . $model->getId();
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getId(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
