<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\behaviors\TestBehavior;
use app\modules\admin\models\Order;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
final class OrderController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            TestBehavior::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     *
     * @return mixed
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query'      => Order::find(),
            'pagination' =>  [
                //'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                      'status' => SORT_ASC,
                ]
            ]

        ]);

        return $this->render('index.twig', [
            'dataProvider' => $dataProvider,
            'status'       => $this->getOrderStatus(),
        ]);
    }

    /**
     * Displays a single Order model.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionView(int $id): string
    {
        return $this->render('view.twig', [
            'model'  => $this->findModel($id),
            'status' => $this->getOrderStatus(),
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Model identifier
     * @return \yii\web\Response
     */
    public function actionDelete(int $id): \yii\web\Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id Model identifier
     * @return Order the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

            throw new \yii\web\NotFoundHttpException(self::HTTP_EXCEPTION_MESSAGE);
    }
}
