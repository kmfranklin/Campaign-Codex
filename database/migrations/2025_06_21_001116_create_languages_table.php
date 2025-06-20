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
    Schema::create('languages', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique();
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->text('description')->nullable();
      $table->boolean('is_exotic')->default(false);
      $table->boolean('is_secret')->default(false);
      $table->string('script_language')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('languages');
  }
};
