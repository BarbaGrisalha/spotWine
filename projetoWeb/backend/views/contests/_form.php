<?php

use common\models\Categories;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Categories::find()->all(), 'category_id', 'name'),
        ['prompt' => 'Selecione uma categoria']
    ) ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class=" mb-4" >
        <div class="card-header bg-gray text-white text-center">
            <h3 class="mb-0">Calendário</h3>
        </div>
        <div class="d-flex justify-content-center gap-5">
            <div class="w-100">
                <?= $form->field($model, 'registration_start_date')->widget(DatePicker::classname(), [
                    'language' => 'pt-BR',
                    'options' => ['placeholder' => 'Selecione a data de início'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd', // Formato no padrão esperado pelo PHP/Yii
                    ],
                ]) ?>

                <?= $form->field($model, 'registration_end_date')->widget(DatePicker::classname(), [
                    'language' => 'pt-BR',
                    'options' => ['placeholder' => 'Selecione a data de fim'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]) ?>

            </div>
            <div class="w-100">
                <?= $form->field($model, 'contest_start_date')->widget(DatePicker::classname(), [
                    'language' => 'pt-BR',
                    'options' => ['placeholder' => 'Selecione a data de início do concurso'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]) ?>

                <?= $form->field($model, 'contest_end_date')->widget(DatePicker::classname(), [
                    'language' => 'pt-BR',
                    'options' => ['placeholder' => 'Selecione a data de fim do concurso'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]) ?>

            </div>

        </div>




    </div>








    <div>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    </div>



    <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'registration' => 'Registration', 'voting' => 'Voting', 'finished' => 'Finished', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
