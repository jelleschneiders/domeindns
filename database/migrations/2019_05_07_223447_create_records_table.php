<?php

use App\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('zone_id');
            $table->string('record_type');
            $table->string('ttl');
            $table->string('name')->nullable();
            $table->text('content');

            $table->string('status')->default(Status::$PENDING_CREATION);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['record_type', 'name', 'deleted_at']);
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
        Schema::dropIfExists('records');
    }
}
