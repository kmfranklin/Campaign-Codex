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
    Schema::create('sizes', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique();
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->integer('rank')->nullable();
      $table->string('suggested_hit_dice')->nullable();
      $table->decimal('space_diameter', 8, 2)->nullable();
      $table->string('distance_unit')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sizes');
  }
};
