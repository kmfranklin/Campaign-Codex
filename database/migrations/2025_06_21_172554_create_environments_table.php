<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('environments', function (Blueprint $table) {
      $table->string('slug')->primary();
      $table->string('name');
      $table->boolean('aquatic')->default(false);
      $table->boolean('interior')->default(false);
      $table->boolean('planar')->default(false);
      $table->text('desc')->nullable();
      $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('environments');
  }
};
