<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\components\{ProductSorterInterface, ProductCriteriaSelectorInterface};

/**
 * Class Product
 *
 * @package app\models
 */
class Product extends ActiveRecord implements ProductSorterInterface, ProductCriteriaSelectorInterface
{
    /**
     * Sets a table name
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'product';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * Connects product table(category_id) and category table(id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Connects product table(product_id) and brand table(id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getBrand(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'product_id']);
    }

    /**
     * Gets the only hit products
     *
     * {@inheritdoc}
     */

    public function getHitProducts(int $minPrice = self::MIN_PRODUCT_PRICE, int $maxPrice = self::MAX_PRODUCT_PRICE): array
    {
        return self::find()->select(['id', 'name', 'price', 'img', 'new', 'sale'])
                           ->where(['between', 'price', $minPrice, $maxPrice])
                           ->andWhere(['hit' => self::PRODUCT_STATUS_TRUE])
                           ->limit(self::PRODUCT_COUNT)
                           ->asArray()
                           ->all();
    }

    /**
     * Gets the only brand products
     *
     * {@inheritdoc}
     */
    public function getBrandProducts(): array // and price between...
    {
        return self::find()->where(['new' => self::PRODUCT_STATUS_TRUE])
                           ->limit(self::PRODUCT_COUNT)
                           ->asArray()
                           ->all();
    }

    /**
     * Gets the only sale products
     *
     * {@inheritdoc}
     */
    public function getSaleProducts(): array
    {
        return self::find()->select(['id', 'name'])
                           ->where(['sale' => self::PRODUCT_STATUS_TRUE])
                           ->limit(self::PRODUCT_COUNT)
                           ->asArray()
                           ->all();
    }

    /**
     * Gets all the products types
     *
     * {@inheritdoc}
     */
    public function getProductsType(): array
    {
        $products = self::find()->select(['keywords'])
                                ->distinct()
                                ->where(['<>', 'keywords', 'NULL'])
                                ->asArray()
                                ->all();

        // Converting retrieved data to a common array
        return ArrayHelper::getColumn($products, 'keywords');
    }

    /**
     * Gets products by their types
     *
     * {@inheritdoc}
     */
    public function getProductByType(): array
    {
        return self::find()->select(['id', 'name', 'price', 'keywords', 'img'])
                           ->orderBy('keywords')
                           ->asArray()
                           ->all();
    }

    /**
     * Gets the number of hit products
     *
     * {@inheritdoc}
     */
    public function getProductsNumber(array $hits): int
    {
        return count($hits);
    }

    /**
     * Gets products by their category
     *
     * {@inheritdoc}
     */
    public function getProductByCategory(int $id): \yii\db\ActiveQuery
    {
        return self::find()->where(['category_id' => $id])->asArray();
    }

    /**
     * Gets products by their brand
     *
     * {@inheritdoc}
     */
    public function getProductByBrand(int $id): \yii\db\ActiveQuery
    {
        return self::find()->where(['brand_id' => $id])->asArray();
    }

    /**
     * @param \yii\db\ActiveQuery $query
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function productsPageOffset(\yii\db\ActiveQuery $query, int $offset, int $limit): array
    {
        return $query->offset($offset)
                     ->limit($limit)
                     ->all();
    }

    /**
     * Looks for products by their name symbols
     *
     * {@inheritdoc}
     */
    public function findProduct(string $productName): array
    {
        return self::find()->select(['id', 'name'])
                           ->where(['like', 'name', $productName])
                           ->asArray()
                           ->all();
    }

    /**
     * Gets product by its identifier
     *
     * {@inheritdoc}
     */
    public function getProductById(int $id): self
    {
        $product = self::find()->select(['id', 'name', 'content', 'price', 'hit', 'new', 'sale'])
                                 ->where(['id' => $id])
                                 ->one();

        if ($product !== null) {
            return $product;
        }

        throw new \yii\web\HttpException(404, 'The requested Item could not be found');

    }
}
