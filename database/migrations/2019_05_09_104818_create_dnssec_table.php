<?php

use App\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnssecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnssec', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('zone_id');

            $table->string('algorithm');
            $table->string('bits');
            $table->string('dnskey');
            $table->string('ds1');
            $table->string('ds2');
            $table->string('ds3');
            $table->string('flags');
            $table->string('pdns_id');
            $table->string('keytype');
            $table->text('privatekey');
            $table->string('type');

            $table->string('status')->default(Status::$OK);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['zone_id', 'deleted_at']);
            $table->foreign('zone_id')->references('id')->on('zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dnssec');
    }
}
