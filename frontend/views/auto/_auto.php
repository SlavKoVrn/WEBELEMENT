<?php
use common\models\Auto;
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="auto-view">

    <h2><?= Model::findOne($model->model_id)->name ?></h2>

    <div class="row">
        <div class="col col-md-6">
            <?php
            $firstImageSrc=Auto::getFirstImageSrc($model->id);
            if (!empty($firstImageSrc)) : ?>
                <?= Html::img($firstImageSrc,['class'=>"img-thumbnail"]) ?>
            <?php endif; ?>
        </div>
        <div class="col col-md-6" style="padding:0px">
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
                    'mileage',
                    'price',
                    'phone',
                ],
            ]) ?>
	    <?= Html::a('Детали', '/auto/view/'.$model->id, ['class'=>'btn btn-primary','style'=>'margin:10px']) ?>
        </div>
    </div>


</div>
