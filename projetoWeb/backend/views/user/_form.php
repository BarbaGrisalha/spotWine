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

    <!-- Campos do modelo UserDetails -->
    <?= $form->field($userDetails, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'phone_number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
