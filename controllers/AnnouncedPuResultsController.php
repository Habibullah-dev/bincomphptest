<?php

namespace app\controllers;

use Yii;
use app\models\Lga;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AnnouncedPuResults;
use yii\web\NotFoundHttpException;
use app\models\AnnouncedPuResultsSearch;

/**
 * AnnouncedPuResultsController implements the CRUD actions for AnnouncedPuResults model.
 */
class AnnouncedPuResultsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AnnouncedPuResults models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnnouncedPuResultsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionLgaResult($lga_id = 0)
    {
        $searchModel = new AnnouncedPuResultsSearch();
        $dataProvider = $searchModel->lgaResultsearch($this->request->queryParams);

        $data = [];

        $parties = [];

        $providers = $dataProvider->getModels();

        foreach ($providers  as $model) {

            if (!isset($data[$model->pollingUnit->lga_id])) {
                $data[$model->pollingUnit->lga_id] = [$model];
            } else {
                $data[$model->pollingUnit->lga_id][] = $model;
            };
        }

        return $this->render('lga-result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
            'parties' => $parties,
            'providers' => $providers
        ]);
    }

    public function actionCreate()
    {
        $model = new AnnouncedPuResults();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Result Stored Successfully.");
                    return $this->redirect(['lga-result', 'lga_id' => $model->pollingUnit->lga_id]);
                } else {
                    Yii::$app->session->setFlash('error', "Error occur not saved.");
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }




    /**
     * Finds the AnnouncedPuResults model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $result_id Result ID
     * @return AnnouncedPuResults the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($result_id)
    {
        if (($model = AnnouncedPuResults::findOne(['result_id' => $result_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
