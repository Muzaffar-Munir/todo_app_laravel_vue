<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSubsctiptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('subsctiptions')) {
        //     Schema::create('subsctiptions', function (Blueprint $table) {
        //         $table->uuid('id')->primary();
        //         $table->string('first_name');
        //         $table->string('last_name');
        //         $table->string('source')->nullable();
        //         $table->uuid('client_id')->index();
        //         $table->timestamp('deleted_at')->nullable();
        //         $table->timestamp('created_at')->useCurrent();
        //         $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        //         $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subsctiptions');
    }
}
