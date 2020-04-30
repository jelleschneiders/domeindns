<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('allow_totp_recovery')->default(true)->after('api_token');
            $table->boolean('allow_support')->default(false)->after('allow_totp_recovery');
            $table->boolean('receive_notifications')->default(true)->after('allow_support');
            $table->boolean('is_admin')->default(false)->after('receive_notifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('allow_totp_recovery');
            $table->dropColumn('allow_support');
            $table->dropColumn('receive_notifications');
            $table->dropColumn('is_admin');
        });
    }
}
