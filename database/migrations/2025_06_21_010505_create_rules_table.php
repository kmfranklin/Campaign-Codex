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
    Schema::create('rules', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique();
      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->string('ruleset')->nullable();
      $table->string('name');
      $table->text('description')->nullable();
      $table->unsignedInteger('index')->nullable();
      $table->unsignedTinyInteger('initial_header_level')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('rules');
  }
};
