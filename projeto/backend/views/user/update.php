<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Update User: ' . $modelProfile->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelProfile->user_id, 'url' => ['view', 'id' => $modelProfile->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formedit', [
        'modelProfile' => $modelProfile, 'mostra_n_utente' => $mostra_n_utente, 'mostra_nif' => $mostra_nif
    ]) ?>

</div>
