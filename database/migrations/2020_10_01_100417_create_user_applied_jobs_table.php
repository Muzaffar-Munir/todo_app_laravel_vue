<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserAppliedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_applied_jobs')) {
            Schema::create('user_applied_jobs', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('freelancer_id')->index();
                $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
                $table->uuid('service_id')->index();
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
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
        Schema::dropIfExists('user_applied_jobs');
    }
}
