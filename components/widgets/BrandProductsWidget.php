<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use app\models\{Brand, Product};


/**
 * Class BrandProductsWidget
 *
 * @package app\components
 */
class BrandProductsWidget extends Widget
{
    /**
     * @var null $brand for Brand model
     */
    private $_brand = null;
    /**
     * @var null $product for Product model
     */
    private $_product = null;

    /**
     * Creating Product and Brand objects for the further usages
     *
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->_product = new Product();
        $this->_brand = new Brand();
    }

    /**
     * Sets all the necessary data for brand widget and uses cache functionality
     *
     * @return string Brands list data
     */
    public function run(): string
    {
        // Trying to retrieve data from cache
        $data = Yii::$app->cache->get('brand');
        // Checking, whether data is cached
        if($data === false) {
            // Getting the brands list data
            $data = $this->_brand->findBrands(); // TODO: Reduce the number of queries
            // Caching data for 5 mins (just testing)
            Yii::$app->cache->set('brand', $data, 60*5);
        }

        return $this->render('index.twig', [
            'items' => $data,
        ]);
    }
}
