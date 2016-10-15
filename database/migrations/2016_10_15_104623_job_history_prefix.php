<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobHistoryPrefix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::getPdo()->exec('
            CREATE TRIGGER `prefix_add` BEFORE INSERT ON `job_skills_history`
             FOR EACH ROW begin
                    DECLARE last_id int;
                    SELECT auto_increment INTO last_id
                FROM information_schema.tables
               WHERE table_name = \'job_skills_history\'
                 AND table_schema = \''.getenv('DB_DATABASE').'\';
                    SET  NEW.prefix_id = CONCAT(\'JBSH\',last_id);

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::getPdo()->exec('DROP TRIGGER `prefix_add`');
    }
}
