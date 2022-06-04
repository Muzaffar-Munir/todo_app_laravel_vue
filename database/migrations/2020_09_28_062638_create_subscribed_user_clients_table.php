<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSubscribedUserClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscribed_user_clients')) {
            Schema::create('subscribed_user_clients', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('client_id')->index();
                $table->uuid('freelancer_id')->index();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
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
        Schema::dropIfExists('subscribed_user_clients');
    }
}
