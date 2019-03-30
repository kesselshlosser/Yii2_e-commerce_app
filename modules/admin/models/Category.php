<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 */
class Category extends ActiveRecord
{
    /**
     * Sets a table name
     *
     * @return string Table name
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * Connects category table by (id) and (parent_id)
     *
     * @return \yii\db\ActiveQuery Connected data
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * Validation
     *
     * @return array Validation rules
     */
    public function rules(): array
    {
        return [
            [['parent_id'], 'integer'],
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
            'id'          => 'Category № ',
            'parent_id'   => 'Parent category',
            'name'        => 'Name',
            'keywords'    => 'Keywords',
            'description' => 'Description',
        ];
    }

    /**
     * Gets list of categories
     *
     * @return array Category data set
     */
    public static function getCategoryByIndex(): array
    {
        return self::find()->select(['id', 'name'])
                           ->indexBy('id')
                           ->asArray()
                           ->all();
    }
}
