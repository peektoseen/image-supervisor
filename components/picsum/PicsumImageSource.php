<?php
/** @noinspection SpellCheckingInspection */
declare(strict_types=1);

/** @noinspection SpellCheckingInspection */

namespace app\components\picsum;

use app\interfaces\ImageSourceInterface;
use app\models\Image;
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
        $notUsedIds = $this->findRandomUnusedSourceIds();
        // get random element from array of not used ids
        return (int) $notUsedIds[array_rand($notUsedIds)];
    }

    /**
     * Generate random source ids not used yet
     * @param int $upperBound
     * @return array
     */
    private  function findRandomUnusedSourceIds(int $upperBound = 1000): array
    {
        // randomly get next image id for moderation. For it - return random not used 100 ids
        $subQuery = (new Query())
            ->select('source_id')
            ->from(Image::tableName());
        return (new Query())
            ->select(['trunc((random() * (:upperBound - 1)) + 1)'])
            ->from(['gs' => "generate_series(1, $upperBound)"])
            ->where(['NOT IN', 'trunc((random() * (:upperBound - 1)) + 1)', $subQuery])
            ->params([':upperBound' => $upperBound])
            ->limit(100)
            ->column();
    }
}
