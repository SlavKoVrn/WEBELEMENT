<?php
use common\models\Model;

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
	    'layout'=>"{summary}\n{items}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_auto',['model'=>$model]);
        },
    ]) ?>

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
