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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role',['administrator','admin','user'])->default('admin');
            $table->integer('designation_id')->nullable();
            $table->string('name',191);
            $table->string('email',30)->unique();
            $table->string('mobile',11)->unique()->nullable();
            $table->string('password_plain',15);
            $table->string('password',400);
            $table->rememberToken();
            $table->string('image',255)->nullable();
            $table->string('cv_path',255)->nullable();
            $table->enum('status',['active','inactive'])->default("active");
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('last_logout_at')->nullable();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('password_reset_code')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
