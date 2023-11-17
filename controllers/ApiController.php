<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace app\controllers;

use app\interfaces\ImageSourceFactoryInterface;
use app\models\Image;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionModerate(): array
    {
        /** @var Image $image */
        $source_id = Yii::$app->request->post('source_id');
        $url = Yii::$app->request->post('url');
        /** @var   ImageSourceFactoryInterface  $imageSourceFactory */
        $imageSourceFactory = Yii::$app->imageSourceFactory;
        $imageSource = $imageSourceFactory->createImageSource($url);
        $image = Image::find()->where(['source_id' => $source_id])->one();
        if(!$image){
            $image = new Image();
            $image->source_id =  $imageSource->getSourceImageId();
            $image->url = $url;
            $image->approved = Yii::$app->request->post('action') == Image::APPROVED ;
            $image->source = basename(str_replace('\\', '/', get_class($imageSource)));
            $image->save();
            if($image->errors){
                Yii::$app->response->statusCode = 400;
                return [
                    'errors' => $image->getErrors()
                ];
            }
        }

        $imageSourceFactory = Yii::$app->imageSourceFactory;
        $imageSource = $imageSourceFactory->createImageSource();
        $imageUrl = $imageSource->getImageUrl();

        return [
            'url' => $imageUrl
        ];
    }
}