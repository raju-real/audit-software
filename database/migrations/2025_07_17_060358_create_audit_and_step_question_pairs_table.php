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
        Schema::create('audit_and_step_question_pairs', function (Blueprint $table) {
            $table->id();
            $table->integer('audit_id');
            $table->integer('audit_step_id');
            $table->integer('audit_step_pair_id');
            $table->integer('question_id');
            $table->integer('sorting_serial');
            $table->string('closed_ended_answer')->nullable();
            $table->string('text_answer')->nullable();
            $table->string('documents',1000)->nullable();
            $table->integer('submitted_by')->nullable();
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
        Schema::dropIfExists('audit_and_step_question_pairs');
    }
};
