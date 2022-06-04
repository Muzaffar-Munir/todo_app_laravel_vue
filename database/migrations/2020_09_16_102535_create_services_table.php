<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->text('description')->nullable();
                $table->integer('price');
                $table->uuid('sales_method')->index();
                $table->uuid('industry')->index();
                $table->string('audience')->nullable();
                $table->string('location')->nullable();
                $table->string('attachment')->nullable()->default('avatar.png');
                $table->string('url');
                $table->string('requirements');
                $table->string('status')->default('active');
                $table->uuid('client_id')->index();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->foreign('sales_method')->references('id')->on('sales_methods')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
}
