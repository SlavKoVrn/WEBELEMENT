<?php
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Auto */

$this->title = Model::findOne($model->model_id)->name;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить автомобиль '.$this->title.' ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'brand_id',
                'value'=>function($model){
                    return Brand::findOne($model->brand_id)->name;
                },
            ],
            [
                'attribute'=>'model_id',
                'value'=>function($model){
                    return Model::findOne($model->model_id)->name;
                },
            ],
            'vehicle_number',
            [
                'attribute'=>'paid',
                'value'=>function($model){
                    if ($model->paid>0)
                        return 'Да';
                    return 'Нет';
                },
            ],
            [
                'attribute'=>'color',
                'format'=>'raw',
                'value'=>function($model){
                    return '<div style="background:'.$model->color.';width:22px;height:22px"></div>';
                },
            ],
            'comment:text',
            'mileage',
            'price',
            'phone',
            [
                'attribute'=>'images',
                'format'=>'raw',
                'value'=>function($model){
                    $_images='';
                    $images=json_decode($model->images);
		    if (is_array($images) and count($images)>0){
	                    foreach ($images as $image){
	                        $_images.=Html::img($image,['width'=>'200px','height'=>'200px','style'=>'margin:5px']);
	                    }
		    }
                    return $_images;
                },
            ],
        ],
    ]) ?>

</div>
