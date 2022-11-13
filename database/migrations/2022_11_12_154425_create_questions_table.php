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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_section_id')->nullable()->constrained('form_sections', 'id')->cascadeOnDelete();
            $table->string('code')->nullable();
            $table->string('text', 255);
            $table->string('hint', 255)->nullable();
            $table->integer('order')->default(0);
            $table->string('type')->nullable();
            $table->boolean('is_required')->default(false);
            $table->string('default_value')->nullable();
            $table->boolean('is_default_value_editable')->nullable()->default(true);
            $table->boolean('is_displayed_from_start')->default(true);
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('default_next_question_id')->nullable()->index();
            $table->boolean('is_exportable')->default(false);
            $table->string('export_code')->nullable();
            $table->integer('export_order')->nullable();
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
        Schema::dropIfExists('questions');
    }
};
