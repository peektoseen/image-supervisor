<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
$name = Yii::t('app', 'Error');
$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?=$exception->getMessage()?>
    </div>

    <p>
        <?=\Yii::t('app', 'Please contact us if you think this is a server error. Thank you.')?>
    </p>

    <a href="/"><?=\Yii::t('app', 'Back to main page')?></a></a>

</div>
