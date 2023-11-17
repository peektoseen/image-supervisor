<?php

/** @var yii\web\View $this */
/** @var string $url */
/** @var int $source_id */

use app\models\Image;

$this->title = 'Image Supervisor';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5">

        <p class="lead <?php if($url):?>hidden<?php endif?>">Image doesn't exist!</p>

        <div class="container ">

            <div class="mb-3 row justify-content-center">
                <div class="loading-spinner"></div>
                <img  alt="image for moderation" class="p-0 rounded-3 col-sm col-xl-7 js-image actual-image" src="<?=$url?>">
            </div>

            <div class="row justify-content-center">

                <a class="col-sm-3 btn m-1 ml-2 btn-lg btn-secondary btn-lg js-moderate-btn" href="javascript:void(0)"
                   data-source-id="<?=$source_id?>" data-action="<?=Image::DENIED?>"><?=Yii::t('app', 'Deny');?></a>

                <a class="col-sm-3 btn m-1 btn-lg btn-primary btn-lg js-moderate-btn" href="javascript:void(0)"
                   data-source-id="<?=$source_id?>" data-action="<?=Image::APPROVED?>"><?=Yii::t('app', 'Approve');?></a>

            </div>
        </div>
    </div>
</div>
