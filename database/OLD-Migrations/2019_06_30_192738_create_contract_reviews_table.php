<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stage_id');
            $table->integer('contract_id');
            $table->integer('status');
            $table->string('comment')->nullable();
            $table->integer('approved_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_reviews');
    }
}
