<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('freelancers')) {
            Schema::create('freelancers', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('industry')->index();
                $table->integer('price')->nullable();
                $table->string('experience')->nullable();
                $table->string('primary_contact')->nullable();
                $table->string('description')->nullable();
                $table->uuid('user_id')->index();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('industry')->references('id')->on('industries')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancers');
    }
}
