<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sobre';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>Este website tem como objetivo representar um sistema online de venda dos produtos farmacêuticos disponíveis para
        o consumidor.</p>
    <p>Este projeto insere-se no âmbito do projeto final de curso de TeSP em Programação de Sistemas de
        Informação.</p>
    <br>
    <i><p>Equipa de desenvolvimento:</p></i>
    <ul>
        <li>Hugo Emanuel Da Luz Moreira Dias - Nº 2220853</li>
        <li>Tiago Santos Da Silva - Nº 2220864</li>
        <li>Pedro Miguel Ideias Francisco - Nº 2220879</li>
    </ul>
    <br>
    <b><p>Ano letivo 2023/2024</p></b>
</div>
