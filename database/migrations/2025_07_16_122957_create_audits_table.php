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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number');
            $table->string('financial_year_id');
            $table->integer('organization_id');
            $table->string('title',191);
            $table->string('slug',255);
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status',['active','inactive'])->default("active");
            $table->enum('priority',['low','medium','high','critical'])->default("high");
            $table->enum('workflow_status',['draft','ongoing','reviewed','approved','rejected','complete','closed'])->default("draft");
            $table->string('reference_document')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('audits');
    }
};
