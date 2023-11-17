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
        $url = Yii::$app->request->post('url');
        /** @var   ImageSourceFactoryInterface  $imageSourceFactory */
        $imageSourceFactory = Yii::$app->imageSourceFactory;
        $imageSource = $imageSourceFactory->createImageSource($url);
        $source_id = $imageSource->getSourceImageId();
        $image = Image::find()->where(['source_id' => $source_id])->one();
        if(!$image && $source_id){
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

        return [
            'url' => $this->getNextImageUrl()
        ];
    }


    /**
     * In answer to user - return next image url without additional web request
     * @return string
     */
    private function getNextImageUrl(): string
    {
        // generate next image url
        $imageSourceFactory = Yii::$app->imageSourceFactory;
        $imageSource = $imageSourceFactory->createImageSource();
        return $imageSource->getImageUrl();
    }
}