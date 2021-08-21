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
            'vehicle_number',
            'mileage',
            'price',
            'phone',
            [
                'filter'=>false,
                'attribute'=>'color',
                'format'=>'raw',
                'content'=>function($model){
                    return '<div style="background:'.$model->color.';height:22px;width:22px"></div>';
                },
            ],
            [
                'filter'=>false,
                'attribute'=>'paid',
                'content'=>function($model){
                    if ($model->paid>0) return 'Да';
                    return 'Нет';
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
