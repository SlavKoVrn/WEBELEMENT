<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
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
    public static function getBrands($addEmpty=false)
    {
        $brands = ArrayHelper::map(self::find()->all(), 'id', 'name');
        if ($addEmpty){
            $brands = [0=>''] + $brands;
        }
        return $brands;
    }

}
