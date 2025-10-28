<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // 主キー（AUTO_INCREMENT）
            $table->string('company_name'); // 会社名（NOT NULL）
            $table->string('street_address')->nullable(); // 住所（NULL許可）
            $table->string('representative_name')->nullable(); // 代表者名（NULL許可）
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};