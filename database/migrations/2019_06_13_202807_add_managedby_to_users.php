<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagedbyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('managed_by')->after('id')->nullable();
            $table->boolean('reseller')->default(false)->after('dangerzone');

            $table->foreign('managed_by')->references('id')->on('users');
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
            $table->dropForeign('users_managed_by_foreign');
            $table->dropColumn('managed_by');
            $table->dropColumn('reseller');
        });
    }
}
