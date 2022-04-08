<?php

use yii\db\Migration;

/**
 * Class m220407_175326_load_data
 */
class m220408_175326_load_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO videos (title, thumbnail, duration, views, added)
VALUES ('Video title', 'video.mp4', FLOOR(random() * 4000)::int, FLOOR(random() * 1000000 + 1)::int, NOW()::DATE - floor(random() * 1000)::int)");

        for ($i = 0; $i < 20; $i++) { // 1048576 записей
            $this->execute("INSERT INTO videos (title, thumbnail, duration, views, added) 
(SELECT title, thumbnail, floor(random() * 4000)::int, floor(random() * 1000000 + 1)::int, NOW()::DATE - floor(random() * 1000)::int FROM videos)");
        }

        $this->loadPagination('views');
        $this->loadPagination('added');

        $this->execute("INSERT INTO pagination_count (\"table\", count) VALUES ('videos', (SELECT COUNT(*) FROM videos))");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('videos');
        $this->truncateTable('video_pagination');
        $this->truncateTable('pagination_count');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220407_175326_load_data cannot be reverted.\n";

        return false;
    }
    */

    private function loadPagination(string $field)
    {
        $this->execute("INSERT INTO video_pagination (".$field.", position)
SELECT * FROM (
SELECT ".$field.", row_number() OVER (ORDER BY ".$field." ASC) FROM videos
) tmp WHERE row_number % 1000 = 0
ON CONFLICT (position) DO UPDATE SET
".$field."=EXCLUDED.".$field.";");
        /*
        INSERT INTO video_pagination (views, position)
        SELECT * FROM (
        SELECT views, row_number() OVER (ORDER BY views ASC) FROM videos
        ) tmp WHERE row_number % 1000 = 0
        ON CONFLICT (position) DO UPDATE SET
        views=EXCLUDED.views;

        INSERT INTO video_pagination (added, position)
        SELECT * FROM (
        SELECT added, row_number() OVER (ORDER BY added ASC) FROM videos
        ) tmp WHERE row_number % 1000 = 0
        ON CONFLICT (position) DO UPDATE SET
        added=EXCLUDED.added;
         */
    }
}
