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
        Schema::create('audit_and_step_pairs', function (Blueprint $table) {
            $table->id();
            $table->integer('audit_id');
            $table->integer('audit_step_id');
            $table->integer('step_no');
            $table->enum('status', ['draft','ongoing','reviewed','approved','rejected','returned'])->default('draft');
            $table->integer('audit_by')->nullable();
            $table->integer('reviewed_by')->nullable();
            $table->text('rejected_for')->nullable();
            $table->text('returned_for')->nullable();
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
        Schema::dropIfExists('audit_and_step_pairs');
    }
};
