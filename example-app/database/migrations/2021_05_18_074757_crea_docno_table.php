<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaDocnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('docnos', function (Blueprint $table) {
            $table->id();
            $table->date('doc_date');
            $table->string('doc_type');
            $table->string('classification');
            $table->string('subject');
            $table->string('docno');
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
        //
        Schema::drop('docnos');
    }
}
