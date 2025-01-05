<?php

namespace backend\controllers;

use common\models\ProducerDetails;
<<<<<<< Updated upstream

use common\models\User;
=======
use common\models\Producers;
>>>>>>> Stashed changes
use yii\data\Pagination;
use yii\web\Controller;
use common\models\Product;
<<<<<<< Updated upstream

=======
use common\models\User;
>>>>>>> Stashed changes
use Yii;
use yii\web\NotFoundHttpException;


class RelatorioController extends Controller
{
    public function actionIndex(){

        $producerId = Yii::$app->request->get('producer_id');
        //dd($producerId);
        $produtosQuery = Product::find()->with(['producer_id','categories']);//mudei de producer_id para producer

        if($producerId){
            $produtosQuery->andWhere(['producer_id'=> $producerId]);
        }
        //Configuração da paginação
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount'=>$produtosQuery->count(),
        ]);
       // dd($produtosQuery);//esse dd($produtosQuery); traz o produtor corretamente.
        //Obter os produtos com a paginação
        $produtos = $produtosQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //Buscar os produtos para o dropdown
        $produtores = ProducerDetails::find()->orderBy(['winery_name'=> SORT_ASC])->all();

        return $this->render('index',[//aqui passamos para a view
            'products' => $produtos,//trocar de produtos para products
            'producers' => $produtores,//trocar de produtores para producers
            'producer_id' => $producerId,
            'pagination' => $pagination
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

        $produtores = ProducerDetails::find()->all();//carrega produtores para o dropDownList
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
        $query = User::find()->with('userDetails');//com with eu adiciono a relação userDetails
        //paginação correta
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'=>5,
            ]);

        $clientes = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('relatorio-clientes', [
            'clientes' => $clientes,
            'pagination' => $pagination,
        ]);
    }

<<<<<<< Updated upstream
=======
    public function actionRelatorioPorProdutor()//$producerId
    {
        //Verifica se o utilizador tem autorização para logar.
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        //Obtém o ID do utilizador logado
        $userId = Yii::$app->user->identity->id;

        //Busca o modelo do Produtor
        //$producer = User::findOne($producerId);
        $producer = ProducerDetails::findOne(['user_id'=> $userId]);

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
            ->where(['p.producer_id'=> $userId])
            ->groupBy('p.category_id')
            ->all();

        return $this->render('relatorio-por-produtor',[
            'produtor' => $producer,
            'categorias' => $query,
        ]);
    }

>>>>>>> Stashed changes
    public function actionSelecionarProdutor()
    {//TODO - NÃO PODE ser esse tipo de query, pois a IDE já faz isso por nós
        $produtores = User::find()
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

<<<<<<< Updated upstream
    public function actionRelatorioPorProdutor()//$producerId
    {
        //Verifica se o utilizador tem autorização para logar.
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        //Obtém o ID do utilizador logado
        $userId = Yii::$app->user->identity->id;

        //Busca o modelo do Produtor
        $producer = ProducerDetails::findOne(['user_id' => $userId]);


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
            ->where(['p.producer_id'=> $producer->id])
            ->groupBy('p.category_id')
            ->all();

        return $this->render('relatorio-por-produtor',[
            'produtor' => $producer,
            'categorias' => $query,
        ]);
    }

    public function actionChart($id){
        //buscando o produtor pelo ID
        $produtor = ProducerDetails::findOne($id);
        $produtorId = $produtor->id;
=======
    public function actionChart()
    {
        // Obter o produtor atualmente logado
        $produtorId = Yii::$app->user->id;
>>>>>>> Stashed changes

        if (!$produtorId) {
            throw new ForbiddenHttpException('Você precisa estar logado para acessar esta página.');
        }

        // Buscar informações do produtor logado
        $produtor = User::findOne($produtorId);

        if (!$produtor) {
            throw new NotFoundHttpException('Produtor não encontrado.');
        }
<<<<<<< Updated upstream
        //Consulta para obter categorias e totais de produtos
        $categorias = (new \yii\db\Query())
            ->select([
                'categories.name AS category_name',
                'SUM(products.stock) AS total_stock' // Soma total de estoque por categoria
            ])
=======

        // Consulta para obter categorias e totais de produtos do produtor logado
        $categorias = (new \yii\db\Query())
            ->select(['categories.name AS category_name', 'SUM(products.stock) AS total_stock'])
>>>>>>> Stashed changes
            ->from('products')
            ->leftJoin('categories', 'products.category_id = categories.category_id')
            ->where(['products.producer_id' => $produtorId])
            ->groupBy('categories.name')
            ->all();

<<<<<<< Updated upstream
// Renderiza a view e envia os dados
=======
        // Renderizar a view e enviar os dados
>>>>>>> Stashed changes
        return $this->render('chart', [
            'produtor' => $produtor,
            'categorias' => $categorias,
        ]);

    }

}