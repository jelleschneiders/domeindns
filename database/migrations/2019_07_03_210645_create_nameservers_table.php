<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateNameserversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nameservers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->boolean('default')->default(false);

            $table->string('nameserver');
            $table->string('ipv4');
            $table->string('ipv6');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::table('nameservers')->insert(
            [
                'id' => Str::uuid(),
                'default' => true,
                'nameserver' => 'ns1.domeindns.nl',
                'ipv4' => '159.69.91.103',
                'ipv6' => '2a01:4f8:c2c:51f0::1',
            ]
        );

        DB::table('nameservers')->insert(
            [
                'id' => Str::uuid(),
                'default' => true,
                'nameserver' => 'ns2.domeindns.nl',
                'ipv4' => '137.74.118.155',
                'ipv6' => '2001:41d0:302:2200::1bc0',
            ]
        );

        DB::table('nameservers')->insert(
            [
                'id' => Str::uuid(),
                'default' => true,
                'nameserver' => 'ns3.domeindns.org',
                'ipv4' => '128.199.37.162',
                'ipv6' => '2a03:b0c0:2:d0::3e6:2001',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nameservers');
    }
}
