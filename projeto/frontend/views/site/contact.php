<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contactos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>
    <h4>Contacto Telefónico:</h4>
    <p><i class="fa fa-phone-alt text-primary me-3"></i>912345678</p>
    <br>
    <h4>Email:</h4>
    <p><i class="fa fa-envelope text-primary me-3"></i><a href="mailto:carolofarmaceutica@gmail.com">carolofarmaceutica@gmail.com</a>
    </p>
    <br>
    <h4>Morada:</h4>
    <p><i class="fa fa-map-marker-alt text-primary me-3"></i>Leiria</p>

</div>
