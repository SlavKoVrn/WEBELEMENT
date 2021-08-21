<?php
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\color\ColorInput;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Auto */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="/admin/font/bootstrap-icons.css">
<style>
.input-group-btn{
	width:400px !important;
}
</style>
<div class="auto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand_id')->dropDownList(Brand::getBrands()) ?>

    <?= $form->field($model, 'model_id')->dropDownList(Model::getModels($model->brand_id)) ?>

    <?= $form->field($model, 'vehicle_number')->widget(MaskedInput::class,[
        'mask'=>'A999AA/9{2,3}',
    ]) ?>

    <?= $form->field($model, 'paid')->checkbox() ?>

    <?= $form->field($model, 'color')->widget(ColorInput::class, [
        'options' => ['placeholder' => 'Цвет автомобиля'],
    ]) ?>

    <?= $form->field($model, 'comment')->textArea() ?>

    <?= $form->field($model, 'mileage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->isNewRecord) : ?>
        <div class="form-group">
            <?php
            $images = json_decode($model->images);
            if (is_array($images) and count($images)>0){
                $config=[];
                foreach ($images as $image){
                    $config[]=[
                        'key'=>$image,
                    ];
                }
            }
            ?>
            <?= $form->field($model, 'images')->widget(FileInput::class, [
                'language' => 'ru',
                'options' => [
                    'multiple' => true,
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'allowedFileExtensions'=>['jpg', 'gif', 'png'],
                    'maxFileCount' => 3,
                    'mainClass' => 'col-md-11',
                    'uploadUrl' => Url::to(['/site/file-upload']),
                    'uploadExtraData' => [
                        'model_id' => $model->id,
                    ],
                    'deleteUrl' => Url::to(['/site/file-delete']),
                    'deleteExtraData' => [
                        'model_id' => $model->id,
                    ],
                    'initialPreviewAsData'=>(is_array($images) and count($images)>0)?true:false,
                    'initialPreview'=>(is_array($images) and count($images)>0)?$images:false,
                    'initialPreviewConfig'=>(is_array($images) and count($images)>0)?$config:false,
                    'browseOnZoneClick' => true,
		    'overwriteInitial'=>false,
                ],
            ]); ?>
        </div>
    <?php endif; ?>

    <div class="form-group" style="padding-top:22px">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js=<<<JS
    $('#auto-brand_id').on('change', function(){
         $.get('/admin/site/models-of-brand/'+$('#auto-brand_id option:selected').val(), 
         function(data) {
               $('#auto-model_id').html(data);
         });
    });
JS;
$this->registerJs($js,$this::POS_READY);