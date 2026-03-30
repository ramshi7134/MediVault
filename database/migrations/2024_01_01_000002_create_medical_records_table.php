<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('family_member_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('hospital_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->date('visit_date')->nullable();
            $table->enum('document_type', ['prescription', 'lab', 'invoice', 'report', 'other'])->default('prescription');
            $table->string('file_path');
            $table->string('file_mime', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->longText('extracted_text')->nullable();
            $table->enum('ocr_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->json('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('family_member_id');
            $table->index('visit_date');
            $table->index('document_type');
            $table->index('doctor_name');
            $table->index('hospital_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
