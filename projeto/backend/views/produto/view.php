<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $produto */

$this->title = $produto->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $produto->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $produto->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $produto,
        'attributes' => [
            'id',
            'nome',
            'prescricao_medica',
            'preco',
            'quantidade',
            'categoria_id',
            'iva_id',
        ],
    ]) ?>
    <?php

    echo '<h2>Imagens:</h2>';
    foreach ($imagemArray as $imagem) {
        echo Html::img($imagem, ['width' => '300px']);
       echo '       ';
    }
      ?>

</div>
