<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('address')->nullable();
                $table->string('abn')->nullable();
                $table->string('business_name');
                $table->string('business_address');
                $table->string('location')->nullable();
                $table->string('referal_email')->nullable();
                $table->string('status')->default('inactive');
                $table->string('stripe_token')->nullable();
                $table->string('subscription_type')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                $table->uuid('user_id')->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('clients');
    }
}
