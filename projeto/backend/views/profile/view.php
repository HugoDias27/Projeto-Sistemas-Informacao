<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Profile $perfil */

$this->title = $perfil->id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $perfil->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $perfil->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar este perfil?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $perfil,
        'attributes' => [
            'id',
            'n_utente',
            'nif',
            'morada',
            'telefone',
            'user_id',
        ],
    ]) ?>

</div>
