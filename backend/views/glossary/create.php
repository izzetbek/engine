<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Site\Glossary\Glossary */

$this->title = 'Create Glossary';
$this->params['breadcrumbs'][] = ['label' => 'Glossaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="glossary-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
