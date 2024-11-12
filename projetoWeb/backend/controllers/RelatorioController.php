<?php

namespace backend\controllers;

use yii\data\Pagination;
use yii\db\Query;
use yii\mutex\RetryAcquireTrait;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Users;
class RelatorioController extends Controller
{
    public function actionRelatorioProdutos(){//busco toda a tabela spotwine.products e depois falo o que quero na view.
        $query = Products::find(); //Inserindo a consuta/busca para os produtos

        $pagination = new Pagination([
            'defaultPageSize'=> 5, //Aqui ficam os produtos por página
            'totalCount'=>$query->count(),//Mostrará o total de registos
        ]);

        //Executa a consulta com a paginação aplicada dentro

        $produtos= $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //renderizando a view e passa os dados dos produtos
        return $this->render('relatorio-produtos',[
            'produtos'=> $produtos,
            'pagination'=> $pagination,
            ]);
    }
    public function actionRelatorioClientes(){
        $query = Users::find();
        $pagination = new Pagination(['totalCount'=> $query->count()]);
        $clientes = $query->offset($pagination->offset)
                          ->limit($pagination->limit)
                          ->all();

        return $this->render('relatorio-clientes',[
            'clientes' => $clientes,
            'pagination'=> $pagination,
        ]);
    }
}