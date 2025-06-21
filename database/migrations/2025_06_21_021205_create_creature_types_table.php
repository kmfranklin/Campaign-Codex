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
    Schema::create('creature_types', function (Blueprint $table) {
      $table->string('key')->primary();
      $table->string('name');
      $table->text('desc')->nullable();
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creature_types');
  }
};
