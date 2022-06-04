<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCancelSubscriptionsTable extends Migration
{
    /**
     * Run the migsubsctiptionsrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('cancel_subscriptions')) {
            Schema::create('cancel_subscriptions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('subscription_id')->index();
                $table->string('reason')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
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
        Schema::dropIfExists('cancel_subscriptions');
    }
}
