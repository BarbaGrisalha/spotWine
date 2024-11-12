<?php
use yii\bootstrap4\Alert;
use backend\controllers\SiteController;

if($status === 'success'){
    echo Alert::widget([
        'options'=>['class'=> 'alert-success'],
        'body' => $message,
    ]);
}else{
    echo Alert::widget([
        'options'=>['class'=>'alert-danger'],
        'body'=> $message,
    ]);
}
?>