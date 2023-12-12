<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Iva $iva */

$this->title = $iva->percentagem;
$this->params['breadcrumbs'][] = ['label' => 'Ivas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="iva-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $iva->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $iva->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $iva,
        'attributes' => [
            'id',
            'percentagem' => [
                'attribute' => 'percentagem',
                'value' => $iva->percentagem . '%',
            ],
            'vigor' => [
                'attribute' => 'vigor',
                'value' => $iva->vigor == 1 ? 'Em vigor' : 'Não está em vigor',
            ],
            'descricao',
        ],
    ]) ?>

</div>
