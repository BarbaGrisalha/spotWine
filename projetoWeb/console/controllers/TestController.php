<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\Contests;

class TestController extends Controller
{
    public function actionDetermineWinner($contestId)
    {
        $contest = Contests::findOne($contestId);

        if (!$contest) {
            echo "Concurso não encontrado!\n";
            return;
        }

        $result = $contest->determineWinner();

        if ($result) {
            echo "Vencedor determinado com sucesso!\n";
        } else {
            echo "Erro ao determinar o vencedor.\n";
        }
    }
}
