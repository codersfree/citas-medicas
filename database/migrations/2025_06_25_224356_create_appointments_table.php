<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('doctor_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('date');

            $table->time('start_time');
            $table->time('end_time');

            $table->integer('duration')->default(15);

            $table->text('reason')->nullable();

            $table->tinyInteger('status')->default(1); // Assuming 1 = scheduled, 2 = completed, 3 = cancelled

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
