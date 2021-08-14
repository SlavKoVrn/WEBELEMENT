<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Auto */

$this->title = 'Добавить автомобиль';
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h5><font color="red">фотографии добавляются только при редактировании</font></h5>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
