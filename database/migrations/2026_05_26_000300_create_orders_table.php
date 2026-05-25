<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('organization')->nullable();
            $table->string('inn', 20)->nullable();
            $table->string('position')->nullable();
            $table->text('comment')->nullable();
            $table->string('status', 50)->default('new');
            $table->string('contract_pdf_path')->nullable();
            $table->string('student_csv_path')->nullable();
            $table->boolean('agreement_accepted')->default(false);
            $table->timestamps();

            $table->index(['status', 'course_id']);
            $table->index(['full_name', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
