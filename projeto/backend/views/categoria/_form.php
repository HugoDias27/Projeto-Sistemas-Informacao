<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Categoria $categoria */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($categoria, 'descricao')->dropDownList(['Medicamentos' => 'Medicamentos','Saúde Oral' =>'Saúde Oral', 'Bens de beleza' => 'Bens de beleza', 'Higiene' => 'Higiene', 'Serviços' =>'Serviços']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
