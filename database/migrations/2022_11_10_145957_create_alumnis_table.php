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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('nim')->index();
            $table->string('fullname');
            $table->string('email')->index()->nullable();
            $table->string('gender');
            $table->string('phone_number')->index()->nullable();
            $table->string('wa_number')->index()->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('provinces', 'id')->nullOnDelete();
            $table->foreignId('regency_id')->nullable()->constrained('regencies', 'id')->nullOnDelete();
            // $table->year('enter_year')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained('batches', 'id')->nullOnDelete();
            $table->year('graduate_year')->nullable();
            $table->foreignId('major_id')->nullable()->constrained('majors', 'id')->nullOnDelete();
            $table->float('gpa')->nullable();
            $table->string('photo')->nullable();
            $table->text('suggestion')->nullable();
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
        Schema::dropIfExists('alumnis');
    }
};
