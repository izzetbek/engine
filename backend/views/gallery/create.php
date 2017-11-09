<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Gallery\AlbumForm */

$this->title = 'Create Album';
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
