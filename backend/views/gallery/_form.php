<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zxbodya\yii2\galleryManager\GalleryManager;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Gallery\AlbumForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'translations')->widget(\common\widgets\MultilingualFormInputs::className(), [
        'fields' => [
            ['name', 'text', ['maxlength' => true]],
            ['description', 'textarea'],
        ]
    ])->label(false) ?>

    <?= (!$model->isNewRecord()) ? GalleryManager::widget(
            [
                'model' => $model->getAlbum(),
                'behaviorName' => 'galleryBehavior',
                'apiRoute' => 'gallery/galleryApi'
            ]
        ) : '';
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord() ? 'Create' : 'Update', ['class' => $model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
