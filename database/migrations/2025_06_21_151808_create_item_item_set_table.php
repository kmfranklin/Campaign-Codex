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
    Schema::create('item_item_set', function (Blueprint $table) {
      $table->id();
      $table->string('item_set_key');
      $table->string('item_key');

      $table->foreign('item_set_key')->references('key')->on('item_sets')->cascadeOnDelete();
      $table->foreign('item_key')->references('key')->on('items')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('item_item_set');
  }
};
