<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class SoftwareupdateRemoveMditlunColumn extends Migration
{
    private $tableName = 'softwareupdate';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('managed_do_it_later_user_notification_times');        
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->string('managed_do_it_later_user_notification_times')->nullable();
        });
    }
}
