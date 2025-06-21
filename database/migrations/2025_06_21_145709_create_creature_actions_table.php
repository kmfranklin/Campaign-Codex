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
    Schema::create('creature_actions', function (Blueprint $table) {
      $table->string('key')->primary(); // e.g. srd_aboleth_detect
      $table->string('name');
      $table->string('action_type')->nullable(); // e.g. LEGENDARY_ACTION, ACTION, etc.
      $table->text('desc')->nullable();
      $table->string('form_condition')->nullable();
      $table->unsignedTinyInteger('legendary_cost')->nullable();
      $table->integer('order')->nullable();
      $table->string('uses_type')->nullable();
      $table->string('uses_param')->nullable();

      $table->string('parent'); // FK to creatures.id
      $table->foreign('parent')->references('id')->on('creatures')->cascadeOnDelete();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creature_actions');
  }
};
