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
        Schema::create('form_response_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_response_id')->constrained('form_responses', 'id')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions', 'id')->cascadeOnDelete();
            $table->string('question_text');
            $table->string('question_code')->nullable();
            $table->longText('response_answer')->nullable();
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
        Schema::dropIfExists('form_response_answers');
    }
};
