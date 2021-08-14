<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Auto;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'models-of-brand'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'file-upload', 'file-delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionModelsOfBrand($brand_id)
    {
        $connection = Yii::$app->getDb();
        $sql=<<<SQL
          SELECT id,name FROM model WHERE code = (SELECT code FROM brand WHERE id = $brand_id);
SQL;
        $command = $connection->createCommand($sql);
        $models = $command->queryAll();
        $options = '';
        foreach ($models as $model){
            $options.= '<option value="'.$model['id'].'">'.$model['name'].'</option>';
        }
        return $options;
    }

    public function actionFileUpload()
    {
        $images = UploadedFile::getInstancesByName('Auto');
        $url='/uploads/'.date('Ymd');
        $path=Yii::getAlias('@frontend/web').$url;
        if (!is_dir($path)){
            FileHelper::createDirectory($path);
        }
        $_images=[];
        foreach ($images as $image){
            if (true==$image->saveAs($path.'/'.$image->name)){
                $_images[]=$url.'/'.$image->name;
            }
        }
        if (count($_images)>0){
            $model=Auto::findOne(Yii::$app->request->post('model_id'));
            $i=json_decode($model->images);
            if (!is_array($i)) $i=[];
            $i=array_merge($i,$_images);
            $model->images=json_encode($i);
            $model->save();
        }
        return true;
    }

    public function actionFileDelete()
    {
        $image=Yii::$app->request->post('key');
        $model=Auto::findOne(Yii::$app->request->post('model_id'));
        $images=json_decode($model->images);
        $_images=[];
        foreach ($images as $_image){
            if ($_image!==$image) $_images[]=$_image;
        }
        $model->images=json_encode($_images);
        if ($model->save())
            return true;
        else
            return false;
    }

}
