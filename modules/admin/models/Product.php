<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\ErrorException;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $content
 * @property double $price
 * @property string $keywords
 * @property string $description
 * @property string $img
 * @property string $hit
 * @property string $new
 * @property string $sale
 */


/**
 * Class Product
 *
 * @package app\modules\admin\models
 */
class Product extends ActiveRecord
{
    /**
     * @var string $image Product image
     */
    public $image;
    /**
     * @var array $collection Set of product images
     */
    public $collection;

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
     * Connects product table(category) and category table(id)
     *
     * @return \yii\db\ActiveQuery Data set
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Validation
     *
     * @return array Validation rules
     */
    public function rules(): array
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['collection'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * Sets fields names
     *
     * @return array Customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'id'          => 'Product ID',
            'category_id' => 'Category ID',
            'name'        => 'Name',
            'content'     => 'Content',
            'price'       => 'Price',
            'keywords'    => 'Keywords',
            'description' => 'Description',
            'image'       => 'Photo',
            'collection'  => 'Gallery',
            'hit'         => 'Hit',
            'new'         => 'New',
            'sale'        => 'Sale',
        ];
    }

    /**
     * Uploads product image
     *
     * @return void
     */
    public function uploadImage(): void
    {
        // Checking, whether image uploading validation returns true
        if ($this->validate()) {
            // Generating path to uploaded image (upload/store/<image_name>.<image_extension>)
            $path = Yii::getAlias('@uploadDir'). $this->image->baseName. '.'. $this->image->extension;

            // Saving uploaded image with generated path
            $this->image->saveAs($path);

            //Attaching image and making it main
            $this->attachImage($path, true);

            // Removing image, whether it exists
            $this->removeImage($path);
        }
    }

    /**
     * Uploads product images
     *
     * @return void
     */
    public function uploadImages(): void
    {
        // Checking, whether image uploading validation returns true
        if ($this->validate()) {

            // Working with all the images, connected to the product
            foreach($this->collection as $file) {
                // Generating path to uploaded image (upload/store/<image_name>.<image_extension>)
                $path = Yii::getAlias('@uploadDir'). $file->baseName. '.'. $file->extension;

                // Saving uploaded image with generated path
                $file->saveAs($path);

                //Attaching image and making it main
                $this->attachImage($path);

                // Removing image, whether it exists
                $this->removeImage($path);
            }
        }
    }

    /**
     * Checks, whether image exists and deletes it
     *
     * @param string $path Path to image
     * @return bool
     */
    private function removeImage(string $path): bool
    {
        try {
            unlink($path);
            return true;
        } catch (ErrorException $e) {
            Yii::warning("file {$path} not  found");
        }

        return false;
    }
}
