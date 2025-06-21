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
    Schema::create('creature_sets', function (Blueprint $table) {
      $table->string('key')->primary(); // e.g., "common-mounts"
      $table->string('name');
      $table->json('creatures'); // array of creature keys
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creature_sets');
  }
};
