<?php

use yii\db\Migration;
use yii\db\pgsql\Schema;

/**
 * Class m220407_174536_init_migration
 */
class m220408_174536_init_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('videos', [
            'title'     => Schema::TYPE_STRING . ' NOT NULL',
            'thumbnail' => Schema::TYPE_STRING . ' NOT NULL',
            'duration'  => Schema::TYPE_STRING . ' NOT NULL',
            'views'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'added'     => Schema::TYPE_TIMESTAMP . ' NOT NULL',
        ]);

        $this->createIndex('idx_views', 'videos', 'views');
        $this->createIndex('idx_added', 'videos', 'added');

        $this->createTable('video_pagination', [
            'position' => Schema::TYPE_INTEGER . ' NOT NULL CONSTRAINT uniq_pos UNIQUE',
            'views'    => Schema::TYPE_INTEGER,
            'added'    => Schema::TYPE_TIMESTAMP,
        ]);

        $this->execute("CREATE INDEX idx_position ON video_pagination USING hash(position);");

        $this->createTable('pagination_count', [
            'table' => Schema::TYPE_STRING . ' NOT NULL',
            'count' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->execute("CREATE UNIQUE INDEX idx_table ON pagination_count (\"table\");");

        /*
         * Проверка правильного порядка
         *
         * ALTER TABLE videos ADD COLUMN views_order INT;
         * ALTER TABLE videos ADD COLUMN id SERIAL;
         * UPDATE videos SET views_order = t.row_number FROM (SELECT id, row_number() OVER (ORDER BY views ASC) FROM videos) t WHERE t.id = videos.id;
         */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('videos');
        $this->dropTable('video_pagination');
        $this->dropTable('pagination_count');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
SELECT * FROM test_table JOIN (SELECT id FROM test_table ORDER BY id LIMIT 100000, 30)
as b ON b.id = test_table.id
    }

    public function down()
    {
        echo "m220407_174536_init_migration cannot be reverted.\n";

        return false;
    }
    */
}
