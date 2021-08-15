<?php
use common\models\Brand;
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AutoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'brand_id')->dropDownList(Brand::getBrands(true)) ?>

    <?= $form->field($model, 'model_id')->dropDownList(Model::getModels($model->brand_id,true)) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js=<<<JS
    $('#autosearch-brand_id').on('change', function(){
         $.get('/admin/site/models-of-brand/'+$('#autosearch-brand_id option:selected').val(), 
         function(data) {
               $('#autosearch-model_id').html(data);
         });
    });
    $('.btn-outline-secondary').on('click', function(){
        $('#autosearch-brand_id option:selected').removeAttr('selected');
        $('#autosearch-brand_id').val(0).change();
        $('#autosearch-model_id').val(0).change();
    });
JS;
$this->registerJs($js,$this::POS_READY);