<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Site\Document\Document */

$this->title = 'Create Document';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
