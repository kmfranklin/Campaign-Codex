<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('class_features', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->string('key')->unique();
      $table->string('name');
      $table->text('description')->nullable();
      $table->string('parent')->nullable(); // references the class (slug-style)

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('class_features');
  }
};
