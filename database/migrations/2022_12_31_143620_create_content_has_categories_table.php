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
        Schema::create('content_has_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('contents', 'id')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('content_has_categories');
    }
};
