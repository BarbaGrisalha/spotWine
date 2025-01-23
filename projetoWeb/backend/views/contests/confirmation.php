<?php

use yii\helpers\Html;

?>
<h1>Inscrição Realizada</h1>
<p>Você se inscreveu com sucesso no concurso: <strong><?= Html::encode($contest->name) ?></strong>.</p>
<p>Data de início: <?= Yii::$app->formatter->asDate($contest->start_date) ?></p>
<p>Data de término: <?= Yii::$app->formatter->asDate($contest->end_date) ?></p>
<p>Boa sorte!</p>

<?= Html::a('Voltar para Concursos', ['producer-index'], ['class' => 'btn btn-primary']) ?>
