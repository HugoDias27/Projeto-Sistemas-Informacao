<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Profile $model */

$this->title = 'Atualizar Perfil';
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="profile-update">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= $this->render('_formedit', [
        'model' => $model, 'mostra_n_utente' => $mostra_n_utente, 'mostra_nif' => $mostra_nif,
    ]) ?>

</div>
