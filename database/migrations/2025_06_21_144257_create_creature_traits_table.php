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
    Schema::create('creature_traits', function (Blueprint $table) {
      $table->string('key')->primary(); // e.g., "srd_aboleth_amphibious"
      $table->string('name');
      $table->text('desc')->nullable();
      $table->string('type')->nullable();
      $table->string('parent'); // foreign key to Creature.id
      $table->timestamps();

      $table->foreign('parent')->references('id')->on('creatures')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creature_traits');
  }
};
