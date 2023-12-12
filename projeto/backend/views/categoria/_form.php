<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Categoria $categoria */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($categoria, 'descricao')->dropDownList(['saude_oral' =>'Saúde Oral', 'bens_beleza' => 'Bens de beleza', 'higiene' => 'Higiene']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
