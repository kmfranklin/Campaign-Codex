<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('weapons', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('damage_dice')->nullable();
      $table->string('damage_type')->nullable();
      $table->decimal('range', 5, 1)->default(0);
      $table->decimal('long_range', 5, 1)->default(0);
      $table->string('distance_unit')->nullable();
      $table->boolean('is_improvised')->default(false);
      $table->boolean('is_simple')->default(false);

      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('weapons');
  }
};
