<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('document_id');
            $table->boolean('is_done')->default(false);
            $table->integer('user_id');
            $table->string('action_need'); // SIGN, APPROVAL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_actions');
    }
}
