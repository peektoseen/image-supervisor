<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Image List');
/** @var $dataProvider ActiveDataProvider */
?>
<h1><?= $this->title ?></h1>

<?php Pjax::begin(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'header' => 'ID',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a($data->source_id, $data->url, ['target' => '_blank']);
            },
        ],
        [
            'header' => Yii::t('app', 'Status'),
            'format' => 'raw',
            'value' => function ($data) {
                return $data->approved ?  Yii::t('app', 'Approved' ) :  Yii::t('app', 'Denied' ) ;
            }
        ],
        [
            'header' => Yii::t('app', 'Delete'),
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $token = Yii::$app->request->get('token');
                    $deleteUrl = Url::to(['delete', 'id' => $model->id]);
                    $trashIcon = (new \yii\grid\ActionColumn())->icons['trash'];
                    return Html::a($trashIcon, ['delete', 'id' => $model->id, 'token' => $token], [
                        'title' => Yii::t('app', 'Delete'),
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            'pjax' => 0, // Disable PJAX for delete link
                        ],
                    ]);
                },
            ],
        ],
    ],
    'pager' => [
        'class' => 'yii\widgets\LinkPager',
    ],
]) ?>

<?php Pjax::end(); ?>
