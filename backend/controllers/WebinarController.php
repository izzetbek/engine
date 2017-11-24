<?php

namespace backend\controllers;

use core\forms\manager\Webinar\WebinarForm;
use core\services\manager\WebinarManageService;
use Yii;
use core\entities\Webinar\Webinar;
use backend\forms\WebinarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * WebinarController implements the CRUD actions for Webinar model.
 */
class WebinarController extends Controller
{
    private $service;

    public function __construct($id, $module, WebinarManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Webinar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebinarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Webinar model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Webinar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new WebinarForm();

        if ($form->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($form, 'imageFile');
            $form->imageFile = $file;
            if ($form->validate()) {
                try {
                    $id = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash($e->getMessage());
                }
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Webinar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $webinar = $this->findModel($id);
        $form = new WebinarForm($webinar);
        if ($form->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($form, 'imageFile');
            $form->imageFile = $file;
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);
                    return $this->redirect(['view', 'id' => $id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash($e->getMessage());
                }
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Webinar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Webinar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Webinar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Webinar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
