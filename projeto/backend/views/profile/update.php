<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Profile $perfil */

$this->title = 'Atualizar Perfil: ' . $perfil->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $perfil->id, 'url' => ['view', 'id' => $perfil->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formedit', [
        'perfil' => $perfil, 'mostra_n_utente' => $mostra_n_utente, 'mostra_nif' => $mostra_nif,
    ]) ?>

</div>
