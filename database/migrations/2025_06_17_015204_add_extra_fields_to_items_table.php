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
    Schema::table('items', function (Blueprint $table) {
      $table->string('armor')->nullable();
      $table->string('armor_detail')->nullable();
      $table->string('weapon')->nullable();
      $table->string('rarity')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('items', function (Blueprint $table) {
      //
    });
  }
};
