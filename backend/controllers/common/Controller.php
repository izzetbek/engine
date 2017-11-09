<?php

namespace backend\controllers\common;

use Yii;

abstract class Controller extends \yii\web\Controller
{
    /** @var  Object $service */
    protected $service;

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        /**
         * @var Object $model
         */
        $model->draft = true;
        if (!$model->save()) {
            throw new \RuntimeException('Unable to activate object');
        }
        $this->redirect('index');
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        /**
         * @var Object $model
         */
        $model->draft = false;
        if (!$model->save()) {
            throw new \RuntimeException('Unable to deactivate object');
        }
        $this->redirect('index');
    }

    public function actionMoveUp($id)
    {
        try {
            $this->service->moveUp($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect('index');
    }

    public function actionMoveDown($id)
    {
        try {
            $this->service->moveDown($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect('index');
    }

    public function actionDeleteThumb($id)
    {
        try {
            $this->service->deleteThumb($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect(['update', 'id' => $id]);
    }

    abstract protected function findModel($id);
}