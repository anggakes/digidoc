<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("created_by");
            $table->string('number');
            $table->string('title');
            $table->string('status'); // draft, send
            $table->string("file_path")->nullable();
            $table->boolean('editable')->default(true);
            $table->string("type");
            $table->text("content");
            $table->string("content_path")->nullable();

            $table->integer("memo_to_department_id")->nullable();
            $table->integer("out_recipient_id")->nullable();


            $table->string("classification_code");
            $table->integer("in_recipient_id")->nullable();

            $table->integer("disposition_to_department_id")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
