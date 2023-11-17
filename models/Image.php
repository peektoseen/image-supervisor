<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "image".
 *
 * @property int $id - primary
 * @property int $source_id - used for generate id for next image via SQL without all records loop
 * @property bool $approved - approved flag
 * @property string $url - image url
 * @property string $source - type of source (it may be several sources for images)
 */
class Image extends ActiveRecord
{

    const APPROVED = 'approved';
    const DENIED = 'denied';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['url', 'source_id', 'source'], 'required'],
            [['url', 'source'], 'string'],
            [['source_id', 'source'], 'unique', 'targetAttribute' => ['source_id', 'source']],
            [['source_id'], 'integer'],
            [['approved'], 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
        ];
    }

    // Assuming you have the necessary rules and configurations for the Image model

    public static function findRandomUnusedSourceIds($upperBound = 1000): array
    {
        $subQuery = (new Query())
            ->select('source_id')
            ->from(self::tableName());

        return (new Query())
            ->select(['trunc((random() * (:upperBound - 1)) + 1)'])
            ->from(['gs' => "generate_series(1, $upperBound)"])
            ->where(['NOT IN', 'trunc((random() * (:upperBound - 1)) + 1)', $subQuery])
            ->params([':upperBound' => $upperBound])
            ->limit(100)
            ->column();
    }
}
