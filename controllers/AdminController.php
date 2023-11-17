<?php /** @noinspection PhpUnused */

namespace app\controllers;

use app\filters\AdminAccessFilter;
use app\models\Image;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\Response;

class AdminController extends Controller
{
    const DEFAULT_PAGE_SIZE = 10;

    // Attach the filter to all actions in this controller
    public function behaviors(): array
    {
        return [
            'adminAccess' => [
                'class' => AdminAccessFilter::class,
            ],
        ];
    }


    public function actionIndex(): string
    {
        $query = Image::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::DEFAULT_PAGE_SIZE, // per page size
            ],
            'sort' => [
                'defaultOrder' => ['source_id' => SORT_ASC], // default order
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(): Response
    {
        $id = Yii::$app->request->get('id');
        /** @var Image $image */
        $image = Image::findOne($id);
        $image->delete();
        return $this->redirect(['admin/index', 'token' => Yii::$app->request->get('token')]); // Redirect to your grid view page
    }

}