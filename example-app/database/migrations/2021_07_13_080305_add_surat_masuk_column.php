<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuratMasukColumn extends Migration
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
            $table->string('surat_keluar_to')->nullable();
            $table->string('surat_keluar_type')->nullable();
            $table->string('surat_keluar_template')->nullable();
            $table->string('surat_address')->nullable();
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
            $table->dropColumn('surat_keluar_to');
            $table->dropColumn('surat_keluar_type');
            $table->dropColumn('surat_address');
        });
    }
}
