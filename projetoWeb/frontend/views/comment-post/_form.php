<div class="blog-posts-form">

    <?php use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment_text')->textInput(['class' => 'form-control']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
