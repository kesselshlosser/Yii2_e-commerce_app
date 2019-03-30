<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use yii\web\HttpException;

/**
 * Class ProductController
 *
 * @package app\controllers
 */
final class ProductController extends AppController
{
    /**
     * For Product object
     *
     * @var Product|null
     */
    private $_product = null;

    /**
     * Creating a Product object for further usages
     */
    public function init()
    {
        parent::init();
        $this->_product = new Product();
    }

    /**
     * Allows to view a product
     *
     * @param int $id product identifier
     * @return string Data set
     * @throws HttpException whether a product has not been found
     */
    public function actionView(int $id): string
    {
        // Getting product by its identifier
        $product = $this->_product->getProductById($id);

        // Getting hit products
        $featuredProducts = $this->_product->getHitProducts();

        // Getting the number of featured products
        $numberOfFeaturedProducts = $this->_product->getProductsNumber($featuredProducts);

        // Getting brand products
        $brandProducts = $this->_product->getBrandProducts();

        // Getting number of brand products
        $numberOfBrandProducts = $this->_product->getProductsNumber($brandProducts);

        // Setting page title and meta info depending on a product
        $this->setMeta( $this->_product::META_TITLE. $product['name'],  $product['keywords'], $product['description']);

        return $this->render('view.twig', [
            'product'  => $product,
            'hits'     => $this->_product->getHitProducts(),
            'count'    => $numberOfFeaturedProducts,
            'new'      => $brandProducts,
            'newCount' => $numberOfBrandProducts,
        ]);
    }
}
