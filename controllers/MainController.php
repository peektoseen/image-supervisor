<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace app\controllers;

use app\interfaces\ImageSourceFactoryInterface;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class MainController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return \yii\console\Response|Response|string
     */
    public function actionIndex(): \yii\console\Response|Response|string
    {
        /** @var ImageSourceFactoryInterface $imageSourceFactory */
        $imageSourceFactory = Yii::$app->imageSourceFactory;
        $imageSource = $imageSourceFactory->createImageSource();
        $imageUrl = $imageSource->getImageUrl();
        $sourceId = $imageSource->getSourceImageId();
        return $this->render('index', ['url' => $imageUrl, 'source_id' => $sourceId]);
    }
}
