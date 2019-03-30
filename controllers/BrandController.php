<?php

namespace app\controllers;

use app\models\{Brand, Product};
use yii\data\Pagination;

/**
 * Class BrandController
 *
 * @package app\controllers
 */
final class BrandController extends AppController
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
        $this->_brand = new Brand();
        $this->_product = new Product();
    }

    /**
     * Provides all the necessary data to a product view
     *
     * @param int $id Product identifier
     * @return string Data set
     */
    public function actionView(int $id): string
    {
        // Getting a products by its brand
        $query = $this->_product->getProductByBrand($id);

        // Creating a pagination functionality
        $pages = new Pagination([
            'totalCount'     => $query->count(),
            'pageSize'       => '6',
            'forcePageParam' => false,
            'pageSizeParam'  => false
        ]);
        // Data offset
        $products = $this->_product->productsPageOffset($query, $pages->offset, $pages->limit);

        return $this->render('view.twig', [
            'products' => $products,
            'pages'    => $pages,
            'brand'    => $this->_brand->getBrandById($id),
        ]);
    }
}
