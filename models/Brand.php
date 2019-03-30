<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\components\HttpDateProviderInterface;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 */
class Brand extends ActiveRecord implements HttpDateProviderInterface
{

    /**
     * Names a table we work with
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'brand';
    }

    /**
     * Connects brand table(id) and product table(brand_id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getProducts(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Product::class, ['brand_id' => 'id']);
    }

    /**
     * Counts the quantity of each product by its brand
     *
     * @return int|string Quantity
     */
    public function getProductsCount(): int
    {
        // TODO: Make caching
        return $this->getProducts()->count();
    }

    /**
     * Validation
     *
     * @return array Validation rules
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
     * @return array
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

    /**
     * Gets list of all brands
     *
     * @return array
     */
    public function findBrands(): array
    {
        return self::find()->select(['id', 'name'])
                           ->indexBy('id')
                           ->all();
    }

    /**
     * Gets brand data by its identifier
     *
     * @param int $id Brand identifier
     * @return array Single brand data
     * @throws \yii\web\HttpException whether brand is not found
     */
    public function getBrandById(int $id): array
    {
        $brand = self::find()->select(['id', 'product_id', 'name', 'keywords', 'description'])
                             ->where(['id' => $id])
                             ->asArray()
                             ->one();

        if ($brand !== null) {
            return $brand;
        }

        throw new \yii\web\HttpException(404, self::HTTP_ITEM_IS_NOT_FOUND);
    }
}
