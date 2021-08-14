<?php
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'brand_id',
                'content'=>function($model){
                    return Brand::findOne($model->brand_id)->name;
                }
            ],
            [
                'attribute'=>'model_id',
                'content'=>function($model){
                    return Model::findOne($model->model_id)->name;
                }
            ],
            'mileage',
            'price',
            'phone',
            [
                'attribute'=>'images',
                'format'=>'raw',
                'content'=>function($model){
                    $_images='';
                    $images=json_decode($model->images);
		    if (is_array($images) and count($images)>0){
	                    foreach ($images as $image){
	                        $_images.=Html::img($image,['width'=>'40px','height'=>'40px','style'=>'margin:1px']);
	                    }
                    }
                    return $_images;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
