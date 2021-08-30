<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecipientToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            //
            $table->string('surat_keluar_name')->default("");
            $table->string('surat_keluar_email')->default("");
            $table->string('surat_keluar_phone')->default("");
            $table->string('surat_keluar_address')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            //
            $table->dropColumn('surat_keluar_name');
            $table->dropColumn('surat_keluar_email');
            $table->dropColumn('surat_keluar_phone');
            $table->dropColumn('surat_keluar_address');
        });
    }
}
