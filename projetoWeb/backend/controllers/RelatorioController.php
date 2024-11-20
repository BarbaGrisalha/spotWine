<?php

namespace backend\controllers;

use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Users;
use yii\web\Response;
use Yii;

class RelatorioController extends Controller
{
    public function actionRelatorioProdutos()
    {
        $query = Products::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $produtos = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('relatorio-produtos', [
            'produtos' => $produtos,
            'pagination' => $pagination,
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

    public function actionReportPieChart()
    {
        $categories = Yii::$app->db->createCommand('
            SELECT category_id, SUM(stock) AS total_stock
            FROM products
            GROUP BY category_id
        ')->queryAll();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $labels[] = 'Categoria ' . $category['category_id'];
            $data[] = (int)$category['total_stock'];
        }

        return $this->render('report', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function actionRelatorioPorProdutor($producerId = null)
    {
        if ($producerId === null) {
            return $this->render('erro', [
                'mensagem' => 'Por favor, selecione um produtor.',
            ]);
        }

        $query = (new \yii\db\Query())
            ->select(['c.name AS category_name', 'SUM(p.stock) AS total_stock'])
            ->from('products p')
            ->innerJoin('categories c', 'p.category_id = c.id')
            ->where(['p.producer_id' => $producerId])
            ->groupBy('p.category_id')
            ->all();

        $producer = Users::findOne($producerId);

        if ($producer === null) {
            return $this->render('erro', [
                'mensagem' => 'Produtor não encontrado.',
            ]);
        }

        return $this->render('relatorio-por-produtor', [
            'produtor' => $producer,
            'categorias' => $query,
        ]);
    }

    public function actionSelecionarProdutor()
    {
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