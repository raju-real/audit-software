<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_step_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_step_id');
            $table->string('question', 1000);
            $table->string('slug', 2000);
            $table->enum('is_closed_ended',['yes','no'])->default('no')->comment('Is this a closed-ended question (Yes,No or N/A)?');
            $table->enum('is_boolean_answer_required',['yes','no'])->default('no')->comment('Is answering the closed-ended question mandatory?');
            $table->enum('has_text_answer',['yes','no'])->default('no')->comment('Does this question need a text answer?');
            $table->enum('is_text_answer_required',['yes','no'])->default('no')->comment('Is the text answer mandatory?');
            $table->enum('has_document',['yes','no'])->default('no')->comment('Does this question need a document upload?');
            $table->enum('is_document_required',['yes','no'])->default('no')->comment('Is the document upload mandatory?');
            $table->integer('sorting_serial');
            $table->enum('status',['active','inactive'])->default("active");
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_step_questions');
    }
};
