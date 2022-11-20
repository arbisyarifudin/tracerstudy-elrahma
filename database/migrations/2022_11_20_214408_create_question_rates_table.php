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
        Schema::create('question_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained('questions', 'id')->cascadeOnDelete();
            $table->integer('lowest_rate')->default(1);
            $table->string('lowest_rate_label')->nullable();
            $table->integer('highest_rate')->default(5);
            $table->string('highest_rate_label')->nullable();
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
        Schema::dropIfExists('question_rates');
    }
};
