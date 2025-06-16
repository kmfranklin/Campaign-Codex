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
    Schema::create('documents', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('slug')->unique();
      $table->string('url')->nullable();
      $table->string('license')->nullable();
      $table->text('description')->nullable();
      $table->text('author')->nullable();
      $table->string('organization')->nullable();
      $table->string('version')->nullable();
      $table->text('copyright')->nullable();
      $table->string('license_url')->nullable();
      $table->string('v2_related_key')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('documents');
  }
};
