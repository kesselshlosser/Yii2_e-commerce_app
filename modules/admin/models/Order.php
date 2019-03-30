<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $quantity
 * @property double $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 */
class Order extends ActiveRecord
{
    /**
     * Sets a table name
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * Connects order table(id) and order_items table(order_id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getOrderItems(): \yii\db\ActiveQuery
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    /**
     * Validation
     *
     * @return array Validation rules
     */
    public function rules(): array
    {
        return [
            [['created_at', 'updated_at', 'quantity', 'sum', 'name', 'email', 'phone', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['quantity'], 'integer'],
            [['sum'], 'number'],
            [['status'], 'string'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
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
            'id'         => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'quantity'   => 'Quantity',
            'sum'        => 'Sum',
            'status'     => 'Status',
            'name'       => 'Name',
            'email'      => 'Email',
            'phone'      => 'Phone',
            'address'    => 'Address',
        ];
    }
}
