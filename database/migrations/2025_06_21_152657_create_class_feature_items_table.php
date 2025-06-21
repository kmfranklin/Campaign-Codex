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
    Schema::create('class_feature_items', function (Blueprint $table) {
      $table->string('key')->primary();
      $table->unsignedTinyInteger('level')->nullable();
      $table->string('column_value')->nullable();
      $table->text('detail')->nullable();

      $table->string('parent');
      $table->foreign('parent')
        ->references('key')
        ->on('class_features')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('class_feature_items');
  }
};
