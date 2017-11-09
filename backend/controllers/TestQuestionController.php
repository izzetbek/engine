<?php

namespace backend\controllers;

use core\entities\OnlineTest\Variant\Variant;
use core\forms\manager\OnlineTest\Question\QuestionForm;
use core\forms\manager\OnlineTest\Variant\VariantsForm;
use core\services\manager\OnlineTest\QuestionManageService;
use Yii;
use core\entities\OnlineTest\Question\Question;
use backend\forms\TestQuestionSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestQuestionController implements the CRUD actions for Question model.
 */
class TestQuestionController extends Controller
{
    private $service;

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

    public function __construct($id, $module, QuestionManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
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
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new QuestionForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $id = $this->service->create($form);
                return $this->redirect(['update', 'id' => $id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionAddVariant($id)
    {
        $question = $this->findModel($id);
        $form = new QuestionForm($question , true);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $question = $this->service->edit($id, $form);
                $form = new QuestionForm($question, true);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'additional' => true,
        ]);
    }

    public function actionRemoveVariant($id)
    {
        if (Yii::$app->request->isAjax) {
            $variant = Variant::findOne($id);
            $variant->delete();
            return true;
        }
        return false;
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $question = $this->findModel($id);
        if (Yii::$app->request->post('additional')) {
            $form = new QuestionForm($question, true);
        } else {
            $form = new QuestionForm($question);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'additional' => false,
        ]);
    }

    /**
     * Deletes an existing Question model.
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
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
