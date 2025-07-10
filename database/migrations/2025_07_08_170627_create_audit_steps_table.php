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
        Schema::create('audit_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('step_no');
            $table->string('title',100);
            $table->string('slug',255);
            $table->string('isa_reference',255)->nullable();
            $table->longText('description')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('audit_steps');
    }
};
