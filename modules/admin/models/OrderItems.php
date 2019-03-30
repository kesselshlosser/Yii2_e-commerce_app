<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property double $price
 * @property integer $quantity_item
 * @property double $sum_item
 */

class OrderItems extends ActiveRecord
{
    /**
     * Sets a table name
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'order_items';
    }

    /**
     * Connects order_items table(order_id) and order table(id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getOrder(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Validation
     *
     * @return array Validation rules
     */
    public function rules(): array
    {
        return [
            [['order_id', 'product_id', 'name', 'price', 'quantity_item', 'sum_item'], 'required'],
            [['order_id', 'product_id', 'quantity_item'], 'integer'],
            [['price', 'sum_item'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'id'            => 'ID',
            'order_id'      => 'Order ID',
            'product_id'    => 'Product ID',
            'name'          => 'Name',
            'price'         => 'Price',
            'quantity_item' => 'Quantity Item',
            'sum_item'      => 'Sum Item',
        ];
    }
}
