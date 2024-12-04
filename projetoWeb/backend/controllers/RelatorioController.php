<?php

namespace backend\controllers;

use common\models\Producers;
use common\models\User;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use common\models\Product;
use backend\models\Users;
use yii\web\Response;
use Yii;
use yii\helpers\ArrayHelper;

class RelatorioController extends Controller
{
    public function actionIndex(){
        $producerId = Yii::$app->request->get('producer_id');
        $produtosQuery = Product::find()->with(['producer','categories']);

        if($producerId){
            $produtosQuery->andWhere(['producer_id'=> $producerId]);
        }

        $produtos = $produtosQuery->all();
        $produtores = Producers::find()->all();

        return $this->render('index',[
            'produtos' => $produtos,
            'produtores' => $produtores,
            'producer_id' => $producerId,
        ]);
    }
    public function actionRelatorioProdutos()
    {
        $query = Product::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $produtos = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $produtores = Producers::find()->all();//carrega produtores para o dropDownList
        $producerId = Yii::$app->request->get('producer_id',null);//Obter o ID do produtore da requisição

        return $this->render('relatorio-produtos', [
            'produtos' => $produtos,
            'pagination' => $pagination,
            'produtores' => $produtores,
            'producerId'=> $producerId,
        ]);
    }

    public function actionRelatorioClientes()
    {
        $query = Users::find();
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $clientes = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('relatorio-clientes', [
            'clientes' => $clientes,
            'pagination' => $pagination,
        ]);
    }

    public function actionRelatorioPorProdutor()//$producerId
    {
        //Verifica se o utilizador tem autorização para logar.
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        //Obtém o ID do utilizador logado
        $producerId = Yii::$app->user->identity->id;

        //Busca o modelo do Produtor
        $producer = Users::findOne($producerId);

        if($producer === null){
            return $this->render('erro',[
                'mensagem'=>'Produtor não encontrado',
            ]);
        }
        //Realiza uma consula para a categoria e produto
        $query = (new \yii\db\Query())
            ->select(['c.name AS category_name','SUM(p.stock) AS total_stock' ])
            ->from('products p')
            ->innerJoin('categories c', 'p.category_id = c.category_id')
            ->where(['p.producer_id'=> $producerId])
            ->groupBy('p.category_id')
            ->all();

        return $this->render('relatorio-por-produtor',[
            'produtor' => $producer,
            'categorias' => $query,
        ]);
    }

    public function actionSelecionarProdutor()
    {//TODO - NÃO PODE ser esse tipo de query, pois a IDE já faz isso por nós
        $produtores = Users::find()
            ->joinWith('user')
            ->where(['type' => 'produtor']) // aqui buscamos na tabela devida
            ->orderBy('name')
            ->all();

        // Verifica se há dados enviados via POST
        if (Yii::$app->request->isPost) {
            $producerId = Yii::$app->request->post('producer_id'); // Obtém o ID do produtor do POST
            if ($producerId) {
                // Redireciona para a ação que gera o relatório, passando o ID do produtor
                return $this->redirect(['relatorio-por-produtor', 'producerId' => $producerId]);
            }
        }

        return $this->render('selecionar-produtor', [
            'produtores' => $produtores,
        ]);
    }


}