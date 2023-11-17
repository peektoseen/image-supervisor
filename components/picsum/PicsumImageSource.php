<?php
/** @noinspection SpellCheckingInspection */
declare(strict_types=1);

/** @noinspection SpellCheckingInspection */

namespace app\components\picsum;

use app\interfaces\ImageSourceInterface;
use app\models\Image;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class for integration with  https://picsum.photos images
 */
class PicsumImageSource implements ImageSourceInterface
{
    const DOMAIN_URL = 'https://picsum.photos';
    const WIDTH = 600; // image width
    const HEIGHT = 500; // image height
    private string $url;

    /**
     * If $url exist - then will get new image from source (generate not moderated id)
     * @param string $url
     */
    public function __construct(string $url = '')
    {
        $this->url = $url ?: implode('/', [self::DOMAIN_URL, 'id', $this->getNextSourceId(), self::WIDTH, self::HEIGHT]);
    }

    /**
     * Get not moderated image url for picsum.
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->url;
    }

    /**
     * Get image id from current url
     * @return int
     */
    public function getSourceImageId(): int
    {
        // regex for extract id from url
        $pattern = '/\/id\/(\d+)/';

        if (preg_match($pattern, $this->url, $matches)) {
            // in $matches[1] exist value for id
            return (int)$matches[1];
        } else {
            return 0;
        }
    }

    /**
     * Return new id for image. Inside - exclude existing images and return not moderated yet.
     * image
     * @return int
     */
    private function getNextSourceId(): int
    {
        return (new Query())
            ->select(['COALESCE(MIN(source_id + 1), 1)'])
            ->from(['t' => Image::tableName()])
            ->where(['NOT EXISTS', (new Query())->select('*')->from(['t1' => Image::tableName()])
                ->where(['t1.source_id' => new Expression('t.source_id + 1')])])
            ->orderBy(new Expression('RANDOM()'))
            ->limit(100) // Limit to 100 records
            ->scalar();
    }
}
