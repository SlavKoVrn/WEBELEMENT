<?php
use common\models\Auto;
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\DetailView;
use slavkovrn\imagegalary\ImageGalaryWidget;


/* @var $this yii\web\View */
/* @var $model common\models\Auto */

$this->title = Model::findOne($model->model_id)->name;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$allImagesSrc=Auto::getAllImagesSrc($model->id);
$images = [];
if (is_array($allImagesSrc) and count($allImagesSrc)>0){
	foreach($allImagesSrc as $src){
	    $images[] = [
	        'src' => $src,
	        'title'=> '',
	    ];
	}
}
?>
<div class="auto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col col-md-6">
            <?php if (count($images)>0) : ?>
                <?= ImageGalaryWidget::widget([
                    'image_width' => 720,       // height of image visible in pixels
                    'image_height' => 540,      // width of image visible in pixels
                    'thumb_width' => 146,        // height of thumb images in pixels
                    'thumb_height' => 106,       // width of thumb images in pixels
                    'items' => 2,               // number of thumb items
                    'images' => $images
                ]) ?>
            <?php endif; ?>
        </div>
        <div class="col col-md-1"></div>
        <div class="col col-md-5">
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
                    'mileage',
                    'price',
                    'phone',
                ],
            ]) ?>
        </div>
    </div>

</div>
