<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuratMasukDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('documents', function (Blueprint $table) {
            //
            $table->date('surat_masuk_date')->nullable();
            $table->string('surat_masuk_from')->nullable();
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
        Schema::table('documents', function (Blueprint $table) {
            //
            $table->dropColumn('surat_masuk_date');
            $table->dropColumn('surat_masuk_from');
        });
    }

}
