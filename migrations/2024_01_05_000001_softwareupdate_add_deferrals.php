<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class SoftwareupdateAddDeferrals extends Migration
{
    private $tableName = 'softwareupdate';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->boolean('force_delayed_minor_updates')->nullable();
            $table->boolean('force_delayed_major_updates')->nullable();
            $table->integer('minor_deferred_delay')->nullable();
            $table->integer('major_deferred_delay')->nullable();
            $table->boolean('allow_rapid_security_response_installation')->nullable();
            $table->boolean('allow_rapid_security_response_removal')->nullable();
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('force_delayed_minor_updates');
            $table->dropColumn('force_delayed_major_updates');
            $table->dropColumn('minor_deferred_delay');
            $table->dropColumn('major_deferred_delay');
            $table->dropColumn('allow_rapid_security_response_installation');
            $table->dropColumn('allow_rapid_security_response_removal');
        });
    }
}
