<?php
namespace console\controllers;

use common\models\Auto;
use common\models\Brand;
use common\models\Model;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Migration;

class InputController extends Controller
{
    public function actionIndex()
    {
        $migration=new Migration();

        $migration->truncateTable(Auto::tableName());

        $faker = \Faker\Factory::create('ru_RU');

        $maxBrands = Brand::find()->count();
        for ($i=1;$i<=50;$i++){
            $randomBrand = random_int(1,$maxBrands);
            $brand_id = Brand::findOne($randomBrand)->id;
            $code = Brand::findOne($randomBrand)->code;
            $models = Model::find()->where(['code' =>$code])->all();
            $_models=[];
            $j=1;
            foreach ($models as $model){
                $_models[$j++]=$model->id;
            }
            $randomModel = random_int(1,count($_models)-1);
            echo $code."\n";
            $migration->insert(Auto::tableName(),[
                'id'=>$i,
                'brand_id'=>$brand_id,
                'model_id'=>$_models[$randomModel],
                'mileage'=>random_int(1,10000).' км.',
                'price'=>number_format(random_int(100000,10000000), 2, ',', ' ').' руб.',
                'phone'=>$faker->phoneNumber,
            ]);
        }

        return ExitCode::OK;
    }
}