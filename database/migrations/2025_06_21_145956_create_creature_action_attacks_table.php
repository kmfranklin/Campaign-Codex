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
    Schema::create('creature_action_attacks', function (Blueprint $table) {
      $table->string('key')->primary(); // e.g., srd_aboleth_tail_tail-attack
      $table->string('name');
      $table->string('attack_type')->nullable(); // e.g., WEAPON, SPELL
      $table->integer('to_hit_mod')->nullable();
      $table->decimal('reach', 6, 2)->nullable();
      $table->integer('range')->nullable();
      $table->integer('long_range')->nullable();
      $table->string('distance_unit')->nullable();
      $table->boolean('target_creature_only')->default(false);

      // Primary damage
      $table->integer('damage_die_count')->nullable();
      $table->string('damage_die_type')->nullable(); // e.g., D6, D8
      $table->string('damage_type')->nullable();
      $table->integer('damage_bonus')->nullable();

      // Optional extra damage
      $table->integer('extra_damage_die_count')->nullable();
      $table->string('extra_damage_die_type')->nullable();
      $table->string('extra_damage_type')->nullable();
      $table->integer('extra_damage_bonus')->nullable();

      $table->string('parent'); // FK to creature_actions.key
      $table->foreign('parent')->references('key')->on('creature_actions')->cascadeOnDelete();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creature_action_attacks');
  }
};
