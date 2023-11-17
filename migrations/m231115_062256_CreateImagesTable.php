<?php /** @noinspection PhpUnused */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m231115_062256_CreateImagesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(), // url of image
            'created_at' => $this->dateTime()->defaultExpression('NOW()')->notNull(), // record dateTime
            'source' => $this->string()->notNull(), // source of image
            'approved' => $this->boolean()->notNull(),
            'source_id' => $this->integer()->notNull(), // image id for this source
        ]);

        $this->createIndex('url', '{{%images}}', 'url');
        $this->createIndex('source_source_id', '{{%images}}', ['source', 'source_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%images}}');
    }
};
