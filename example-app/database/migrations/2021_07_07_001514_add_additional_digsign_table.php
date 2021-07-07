<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalDigsignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('digsigns', function (Blueprint $table) {
            //
            $table->string('label')->nullable();
            $table->string('departement')->nullable();
            $table->string('signed_by_name')->nullable();
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
        Schema::table('digsigns', function (Blueprint $table) {
            //
            $table->dropColumn('label');
            $table->dropColumn('departement');
            $table->dropColumn('signed_by_name');
        });
    }
}
