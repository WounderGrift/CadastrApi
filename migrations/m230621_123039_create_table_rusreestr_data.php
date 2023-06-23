<?php

use yii\db\Migration;

class m230621_123039_create_table_rusreestr_data extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `rus_reestr` (
            `id`             INT          UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `cadastr_number` VARCHAR(255),
            `address`        VARCHAR(255),
            `price`          FLOAT,
            `area`           FLOAT,
            `date_create`    DATETIME,
            `date_update`    DATETIME
                          
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->execute("CREATE INDEX `idx_cadastr` ON `rus_reestr` (cadastr_number);");
    }

    public function down()
    {
        $this->execute('DROP TABLE rus_reestr;');
    }
}