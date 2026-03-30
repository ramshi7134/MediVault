<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shared_records', function (Blueprint $table) {
            $table->string('group', 255)->nullable()->after('medical_record_id');
            $table->foreignId('medical_record_id')->nullable()->change();
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::table('shared_records', function (Blueprint $table) {
            $table->dropIndex(['group']);
            $table->dropColumn('group');
            $table->foreignId('medical_record_id')->nullable(false)->change();
        });
    }
};
