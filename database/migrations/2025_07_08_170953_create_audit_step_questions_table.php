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
            $table->string('question', 100);
            $table->boolean('is_closed_ended')->default(true)->comment('Is this a closed-ended question (Yes, or N/A)?');
            $table->boolean('is_boolean_answer_required')->default(true)->comment('Is answering the closed-ended question question mandatory?');
            $table->boolean('has_text_answer')->default(true)->comment('Does this question need a text answer?');
            $table->boolean('is_text_answer_required')->default(true)->comment('Is the text answer mandatory?');
            $table->boolean('has_document')->default(true)->comment('Does this question need a document upload?');
            $table->boolean('is_document_required')->default(true)->comment('Is the document upload mandatory?');
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
        Schema::dropIfExists('audit_step_questions');
    }
};
