<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Profile $model */

$this->title = "Utilizador";
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1 align="center"><?= Html::encode($model->user->username) ?></h1>
    <hr>

    <p>
        <?= Html::a('Editar perfil', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'n_utente',
            'user.username',
            'user.email',
            'nif',
            'morada',
            'telefone',
        ],
    ]) ?>

</div>
