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
        Schema::create('alumni_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis', 'id')->cascadeOnDelete();
            $table->string('institution_name');
            $table->string('institution_address');
            $table->text('institution_contacts')->nullable();
            $table->string('job_title');
            $table->year('start_year');
            $table->year('end_year')->nullable();
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
        Schema::dropIfExists('alumni_jobs');
    }
};
