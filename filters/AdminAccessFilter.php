<?php
declare(strict_types=1);

namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class AdminAccessFilter extends ActionFilter
{
    public string $tokenParam = 'token';
    public string $requiredToken = 'xyz123';

    /**
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool
    {
        $token = Yii::$app->request->get($this->tokenParam);
        // you can override token through env
        $requiredToken = getenv('ADMIN_TOKEN') ?: $this->requiredToken;
        if ($token !== $requiredToken ) {
            throw new ForbiddenHttpException(Yii::t('app','Access denied. Invalid or missing token.'));
        }

        return parent::beforeAction($action);
    }
}