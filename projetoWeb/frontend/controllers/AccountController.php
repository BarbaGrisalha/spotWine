<?php

namespace frontend\controllers;

use common\models\ConsumerDetails;
use common\models\Invoices;
use common\models\User;
use frontend\models\ChangePasswordForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AccountController extends Controller
{
    public function actionInvoices()
    {
        $userId = Yii::$app->user->id; // Obtém o ID do usuário logado

        // Buscar todas as faturas do usuário logado
        $invoices = Invoices::find()
            ->joinWith('orders') // Junta com Order
            ->where(['orders.user_id' => $userId]) // Filtra pelo usuário logado
            ->with(['orderItems.product']) // Carrega os itens e os produtos comprados
            ->all();

        return $this->render('/account/invoices', [
            'invoices' => $invoices
        ]);
    }

    public function actionInvoiceDetails($id)
    {
        $invoice = Invoices::findOne($id);


        return $this->render('/account/invoiceDetails', [
            'invoice' => $invoice
        ]);
    }
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $userId = Yii::$app->user->id; // Obtém o ID do usuário autenticado

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Senha alterada com sucesso!');
            return $this->redirect(['account/profile', 'id' => $userId]); // Redireciona para a view do perfil
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionProfile($id)
    {
        $user = User::findOne($id);
        $consumerDetails = $user->hasOne(ConsumerDetails::class, ['user_id' => 'id'])->one();

        if (!$user) {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }

        return $this->render('profile', [
            'user' => $user,
            'consumerDetails' => $consumerDetails,
        ]);
    }




}