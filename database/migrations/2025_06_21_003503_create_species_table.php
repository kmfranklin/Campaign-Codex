<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('species', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique();
      $table->string('name');
      $table->text('description')->nullable();
      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
      $table->string('subspecies_of')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('species');
  }
};
