<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalRecipientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_recipients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("email")->nullable();
            $table->string("name");
            $table->string("phone")->nullable();
            $table->string("address")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_recipients');
    }
}
