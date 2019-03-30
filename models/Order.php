<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\Session;
use app\components\{MessengerInterface, OrderMailerInterface, OrderSaverInterface};

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
class Order extends ActiveRecord implements MessengerInterface, OrderMailerInterface, OrderSaverInterface
{
    /**
     * @var null $_orderItem Intended for OrderItems object
     */
    private $_orderItem = null;

    /**
     * Creating all the necessary objects for further usages
     */
    public function init()
    {
        parent::init();
        $this->_orderItem = new OrderItems();
    }

    /**
     * Sets a table name
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
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
     * @return array validation rules
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'phone', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['quantity'], 'integer'],
            [['sum'], 'number'],
            [['status'], 'boolean'],
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
            'name'    => 'Name',
            'email'   => 'Email',
            'phone'   => 'Phone',
            'address' => 'Address',
        ];
    }

    /**
     * Writes order info to DB
     *
     * @param array $items User ordered products
     * @param int $order_id Order identifier
     * @return void
     */
    public function saveOrderItems(array $items, int $order_id): void
    {
        foreach ($items as $id => $item) {
            // Filling order table fields by user ordered products
            $this->_orderItem->order_id = $order_id;
            $this->_orderItem->product_id = $id;
            $this->_orderItem->name = $item['name'];
            $this->_orderItem->price = $item['price'];
            $this->_orderItem->quantity_item = $item['quantity'];
            $this->_orderItem->sum_item = $item['quantity']*$item['price'];

            // Saving the filling result of user ordered items
            $this->_orderItem->save();
        }
    }

    /**
     * Displays the message of successfully order made
     *
     * {@inheritdoc}
     */
    public function showSuccessMessage(string $key = self::FLASH_KEY_SUCCESS, string $value = self::FLASH_MESSAGE_SUCCESS): ?string
    {
        return Yii::$app->session->setFlash($key, $value);
    }

    /**
     * Displays the message of failed order made
     *
     * {@inheritdoc}
     */
    public function showErrorMessage(string $key = self::FLASH_KEY_ERROR, string $value = self::FLASH_MESSAGE_ERROR): ?string
    {
        return Yii::$app->session->setFlash($key, $value);
    }

    /**
     * Sends user order to their email address
     *
     * {@inheritdoc}
     */
    public function sendOrderToMail(Session $params, array $letterOptions): void
    {
        Yii::$app->mailer->compose('order', ['session' => $params])
                         ->setFrom([$letterOptions['sender'] => $letterOptions['mask']])
                         ->setTo($letterOptions['receiver'])
                         ->setSubject($letterOptions['subject'])
                         ->send();
    }
}
