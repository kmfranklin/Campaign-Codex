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
    Schema::create('item_categories', function (Blueprint $table) {
      $table->string('key')->primary(); // e.g., "adventuring-gear"
      $table->string('name');
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('item_categories');
  }
};
