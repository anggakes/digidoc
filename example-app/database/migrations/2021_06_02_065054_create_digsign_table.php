<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigsignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digsigns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('data')->nullable();
            $table->integer("sign_by_id")->nullable();
            $table->string('sign_uniqueness')->nullable();
            $table->string('document_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digsigns');
    }
}
