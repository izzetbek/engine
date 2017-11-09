<?php

use mihaildev\elfinder\ElFinder;

$this->title = "File Manager";

?>
<div class="file-manager" style="height: calc(100vh - 175px)">

    <?= ElFinder::widget([
        'language'     => 'en',//Yii::$app->params['defaultLanguage'],
        'controller'   => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'containerOptions' => [
            'style' => 'height: 100%'
        ],
        //'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        //'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
    ]); ?>

</div>