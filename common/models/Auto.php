<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "auto".
 *
 * @property int $id
 * @property int|null $brand_id
 * @property int|null $model_id
 * @property string|null $vehicle_number
 * @property string|null $color
 * @property int|null $paid
 * @property string|null $images
 * @property string|null $mileage
 * @property string|null $price
 * @property string|null $phone
 */
class Auto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'model_id', 'paid'], 'integer'],
            [['images', 'comment'], 'string'],
            [['mileage', 'price', 'phone'], 'string', 'max' => 255],
            [['vehicle_number', 'color'], 'string', 'max' => 20],
            [['brand_id', 'model_id', 'vehicle_number', 'color'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'brand_id' => 'Марка',
            'model_id' => 'Модель',
            'vehicle_number' => 'Номер',
            'color' => 'Цвет',
            'paid' => 'Оплачено',
            'images' => 'Фото',
            'comment' => 'Комментарий',
            'mileage' => 'Пробег',
            'price' => 'Цена',
            'phone' => 'Телефон',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand() {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel() {
        return $this->hasOne(Model::class, ['id' => 'model_id']);
    }

    public static function getFirstImageSrc($auto_id)
    {
        $model=self::findOne($auto_id);
        $images=json_decode($model->images);
        if (is_array($images) and count($images)>0){
            return $images[0];
        }
        return null;
    }

    public static function getAllImagesSrc($auto_id)
    {
        $model=self::findOne($auto_id);
        $images=json_decode($model->images);
        if (is_array($images) and count($images)>0){
            return $images;
        }
        return null;
    }

}
