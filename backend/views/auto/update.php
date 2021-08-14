<?php
use common\models\Model;

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Auto */

$this->title = 'Изменить: ' . Model::findOne($model->model_id)->name;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Model::findOne($model->model_id)->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="auto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
