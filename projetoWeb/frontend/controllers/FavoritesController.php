<?php

namespace frontend\controllers;

use common\models\CartItems;
use common\models\Favorites;
use common\models\LoginForm;
use frontend\models\ProductFrontSearch;
use frontend\models\PromocoesViewModel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class FavoritesController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['delete', 'index', 'toggleFavorites'],
                'rules' => [

                    [
                        'actions' => ['delete', 'index', 'toggleFavorites'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            Yii::$app->session->setFlash('danger', 'Você precisa fazer login para favoritar um produto.');

            return $this->redirect(['/site/login']);
        }
        $searchModel = new ProductFrontSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, $user->id);

        $products = array_map(fn($product) => new promocoesViewModel($product), $dataProvider->getModels());
        $dataProvider->setModels($products);


        return $this->render('/site/favorites', [
            'dataProvider' => $dataProvider,
            'cartItemModel' => new CartItems(),
            ]);
    }

    public function actionToggleFavorite($productId)
    {
        $consumerId = Yii::$app->user->identity->id; // Id do usuário logado

        if (!$consumerId) {
            Yii::$app->session->setFlash('warning', 'Você precisa fazer login para favoritar produtos.');
            return $this->redirect(['site/register']);
        }

        $favorite = Favorites::findOne(['user_id' => $consumerId, 'product_id' => $productId]);

        if ($favorite) {
            $favorite->delete(); // Remove dos favoritos
            Yii::$app->session->setFlash('success', 'Produto favorito removido com sucesso.');
        } else {
            $newFavorite = new Favorites();
            $newFavorite->user_id = $consumerId;
            $newFavorite->product_id = $productId;
            $newFavorite->save(); // Adiciona aos favoritos
            Yii::$app->session->setFlash('success', 'Produto favorito adicionado com sucesso.');
        }

        return $this->redirect(Yii::$app->request->referrer); // Retorna para a página anterior
    }


}
