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
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained('questions', 'id')->cascadeOnDelete();
            $table->string('text', 255);
            $table->string('hint', 255)->nullable();
            $table->string('value');
            $table->boolean('is_custom_value')->default(false);
            $table->integer('order')->default(0);
            $table->string('code')->nullable();
            $table->string('export_code')->nullable();
            $table->unsignedBigInteger('next_question_id')->nullable()->index();
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
        Schema::dropIfExists('question_options');
    }
};
