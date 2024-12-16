<div class="users-form">

    <?php use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $form = ActiveForm::begin(); ?>

    <!-- Campos do modelo User -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php else: ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => ''])->label('Nova Senha (deixe em branco para manter)') ?>
    <?php endif; ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value'=>'']) ?>


    <!-- Campos do modelo ProducersDetails -->
    <?= $form->field($producerDetails, 'winery_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'location')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'complement')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'postal_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'region')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'notes')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
