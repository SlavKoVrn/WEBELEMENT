<?php

namespace frontend\controllers;

use common\models\Auto;
use frontend\models\AutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AutoController implements the CRUD actions for Auto model.
 */
class AutoController extends Controller
{

    /**
     * Lists all Auto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Auto model.
     * @param int $id Ид
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Auto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Ид
     * @return Auto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Auto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
