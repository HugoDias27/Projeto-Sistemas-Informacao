<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Profile $perfil */

$this->title = 'Criar Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'perfil' => $perfil,
    ]) ?>

</div>
