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

    <h1><?= Html::encode($model->user->username) ?></h1>

    <p>
        <?= Html::a('Editar perfil', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'n_utente',
                'label' => 'Número de utente',
            ],
            [
                'attribute' => 'user.username',
                'label' => 'Username',
            ],
            [
                'attribute' => 'user.email',
                'label' => 'Email',
            ],
            'nif',
            'morada',
            'telefone',
        ],
    ]) ?>

</div>
