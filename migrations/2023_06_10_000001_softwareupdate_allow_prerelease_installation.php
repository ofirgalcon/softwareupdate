<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class SoftwareupdateAllowPrereleaseInstallation extends Migration
{
    private $tableName = 'softwareupdate';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->boolean('allow_prerelease_installation')->nullable();

            $table->index('allow_prerelease_installation');
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('allow_prerelease_installation');
        });
    }
}
