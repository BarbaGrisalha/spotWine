<?php



use common\models\Categories;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User $user */
?>


<div class="product-form">
    <?php $form = ActiveForm::begin() ?>
   <?php $user = Yii::$app->user->identity; ?>

    <h1 class="text-center"><?=$this->title?></h1>


    <?php if ($user === null) {
    throw new \yii\web\ForbiddenHttpException('Usuário não autenticado.');
    }?>
    <?php if (Yii::$app->user->can('admin')): ?>
    <?= $form->field($model, 'producer_id')->dropDownList(
            ArrayHelper::map(
                \common\models\ProducerDetails::find()->all(), // Pegando direto da tabela correta
                'id',  // ID correto da tabela producer_details
                'winery_name' // Nome da vinícola, ou outro campo adequado
            ),
            ['prompt' => 'Select Producer']
    ) ?>
    <?php else: ?>
    <?= $form->field($model, 'producer_id')->hiddenInput([
        'value' => $user->isProducer() ? $user->id : null, // Apenas se for produtor
    ])->label(false) ?>
    <?php endif; ?>


    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(
            Categories::find()->asArray()->all(),
            'category_id',
            'name'
        ),
        ['prompt' => 'Select Category']
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'stock')->textInput() ?>
    <div>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>