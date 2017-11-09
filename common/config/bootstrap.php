<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@cabinet', dirname(dirname(__DIR__)) . '/cabinet');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@core', dirname(dirname(__DIR__)) . '/core');

Yii::setAlias('@backendUpload', 'http://backend.engine.loc/upload');
Yii::setAlias('@frontendUpload', 'http://engine.loc/upload');