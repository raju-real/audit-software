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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');
            $table->string('label');
            $table->string('type'); // text, textarea, select, checkbox, file, signature, radio, date, number ...
            $table->json('options')->nullable(); // for select/checkbox/radio options: JSON array
            $table->integer('order')->default(0);
            $table->boolean('required')->default(false);
            $table->boolean('multiple')->default(false); // for file/select multi
            $table->string('placeholder')->nullable();
            $table->text('paragraph')->nullable();
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
        Schema::dropIfExists('form_fields');
    }
};
