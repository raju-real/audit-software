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
        Schema::create('form_submission_files', function (Blueprint $table) {
            $table->id();
            $table->integer('submission_id');
            $table->integer('field_id')->nullable();
            $table->string('field_name')->nullable(); // fallback
            $table->string('file_path'); // storage path
            $table->string('type')->default('image'); // image|signature|other
            $table->string('mime')->nullable();
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
        Schema::dropIfExists('form_submission_files');
    }
};
