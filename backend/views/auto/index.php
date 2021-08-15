<?php
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

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
        'layout'=>"{summary}\n{items}",
        'columns' => [
            [
                'attribute'=>'brand_id',
                'filter'=>Brand::getBrands(),
                'content'=>function($model){
                    return Brand::findOne($model->brand_id)->name;
                }
            ],
            [
                'attribute'=>'model_id',
                'filter'=>Model::getModels($searchModel->brand_id),
                'content'=>function($model){
                    return Model::findOne($model->model_id)->name;
                }
            ],
            'mileage',
            'price',
            'phone',
            [
		'filter'=>false,
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

    <?=  LinkPager::widget([
        'pagination'=>$dataProvider->pagination,
        'maxButtonCount' => 5,
        'nextPageLabel' => '>>',
        'prevPageLabel' => '<<',
        'nextPageCssClass' => 'page-item',
        'prevPageCssClass' => 'page-item',
        'pageCssClass' => 'page-item',
        'linkOptions' => [
            'class'=> 'page-link'
        ],
        'disabledListItemSubTagOptions' => [
            'class'=> 'page-link'
        ],
      ]) ?>

    <?php Pjax::end(); ?>

</div>
