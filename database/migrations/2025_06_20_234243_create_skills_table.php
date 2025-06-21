<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('skills', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->string('name');
      $table->string('ability')->nullable();
      $table->text('description')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('skills');
  }
};
