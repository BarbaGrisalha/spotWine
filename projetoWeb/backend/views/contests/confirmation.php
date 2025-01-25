<?php

use yii\helpers\Html;
$this->title = 'Inscrição Realizada';
?>

<p>Você se inscreveu com sucesso no concurso: <strong><?= Html::encode($contest->name) ?></strong>.</p>
<p>Data de início: <?= Yii::$app->formatter->asDate($contest->contest_start_date) ?></p>
<p>Data de término: <?= Yii::$app->formatter->asDate($contest->contest_end_date) ?></p>
<p>Boa sorte!<i class="fas "></i></p>

<?= Html::a('<i class="fas fa-arrow-left"></i> Concursos ', ['producer-index'], ['class' => 'btn btn-primary']) ?>
