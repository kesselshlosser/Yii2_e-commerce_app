<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\components\{CategorySorterInterface, MetaProviderInterface, HttpDateProviderInterface, ProductDateProviderInterface};

/**
 * Class Category
 *
 * @package app\models
 */
class Category extends ActiveRecord implements CategorySorterInterface, MetaProviderInterface, HttpDateProviderInterface,
                                               ProductDateProviderInterface
{
    /**
     * Names a table we work with
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'category';
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
     * Connects category table(id) and product table(category_id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getProducts(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * Gets category data by its identifier
     *
     * {@inheritdoc}
     */
    public function getCategoryById(int $id): array
    {
        $category = self::find()->select(['id', 'parent_id', 'name', 'keywords', 'description'])
                                ->where(['id' => $id])
                                ->asArray()
                                ->one();

        if ($category !== null) {
            return $category;
        }

        throw new \yii\web\HttpException(404, 'The requested Item could not be found');
    }

    /**
     * Gets category data by its index
     *
     * {@inheritdoc}
     */
    public function getCategoryByIndex(): array
    {
        return self::find()->select(['id', 'parent_id', 'name'])
                           ->indexBy('id')
                           ->asArray()
                           ->all();
    }
}
