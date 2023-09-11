<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class SoftwareupdateManaged extends Migration
{
    private $tableName = 'softwareupdate';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->integer('managed_do_it_later_deferral_count')->nullable();
            $table->integer('maximum_managed_do_it_later_deferral_count')->nullable();
            $table->string('managed_do_it_later_user_notification_times')->nullable();
            $table->string('managed_product_keys')->nullable();
            
            $table->index('managed_do_it_later_deferral_count');
            $table->index('maximum_managed_do_it_later_deferral_count');
            $table->index('managed_do_it_later_user_notification_times');
            $table->index('managed_product_keys');
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('managed_do_it_later_deferral_count');        
            $table->dropColumn('maximum_managed_do_it_later_deferral_count');        
            $table->dropColumn('managed_do_it_later_user_notification_times');        
            $table->dropColumn('managed_product_keys');        
        });
    }
}
