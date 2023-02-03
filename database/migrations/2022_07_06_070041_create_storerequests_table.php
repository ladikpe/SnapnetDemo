<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorerequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storerequests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id');
            $table->string('department_head_id');
            $table->string('purpose');
            $table->mediumText('description');
            $table->string('request_type');
            $table->string('document_name');
            $table->string('document_path');
            $table->integer('status_id');
            $table->integer('created_by');
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
        Schema::dropIfExists('storerequests');
    }
}
