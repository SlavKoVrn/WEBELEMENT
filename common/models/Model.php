<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "model".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return array
     */
    public static function getModels($brand_id)
    {
        if ($brand_id>0){
            $brand=Brand::findOne($brand_id);
            $code=$brand->code;
        }else{
            $code='audi';
        }
        return ArrayHelper::map(self::find()->where(['code'=>$code])->all(), 'id', 'name');
    }

}
