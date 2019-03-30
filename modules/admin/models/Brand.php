<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 */
class Brand extends ActiveRecord
{
    /**
     * Sets a table name
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'brand';
    }

    /**
     * Validation
     *
     * @return array validation rules
     */
    public function rules(): array
    {
        return [
            [['product_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * Sets fields names
     *
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'id'          => 'ID',
            'product_id'  => 'Product ID',
            'name'        => 'Name',
            'keywords'    => 'Keywords',
            'description' => 'Description',
        ];
    }
}
