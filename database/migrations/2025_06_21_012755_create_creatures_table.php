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
    Schema::create('creatures', function (Blueprint $table) {
      $table->string('id')->primary(); // srd_aboleth
      $table->string('name');
      $table->string('type')->nullable();
      $table->string('size')->nullable();
      $table->string('alignment')->nullable();
      $table->string('category')->nullable();
      $table->string('subcategory')->nullable();

      $table->string('armor_detail')->nullable();
      $table->integer('armor_class')->nullable();
      $table->string('hit_dice')->nullable();
      $table->integer('hit_points')->nullable();
      $table->decimal('challenge_rating_decimal', 5, 3)->nullable();
      $table->integer('passive_perception')->nullable();
      $table->decimal('proficiency_bonus', 5, 2)->nullable();

      $table->decimal('walk', 5, 2)->nullable();
      $table->decimal('climb', 5, 2)->nullable();
      $table->decimal('fly', 5, 2)->nullable();
      $table->decimal('swim', 5, 2)->nullable();
      $table->decimal('burrow', 5, 2)->nullable();
      $table->boolean('hover')->nullable();

      $table->integer('ability_score_strength')->nullable();
      $table->integer('ability_score_dexterity')->nullable();
      $table->integer('ability_score_constitution')->nullable();
      $table->integer('ability_score_intelligence')->nullable();
      $table->integer('ability_score_wisdom')->nullable();
      $table->integer('ability_score_charisma')->nullable();

      $table->decimal('initiative_bonus', 5, 2)->nullable();

      $table->decimal('darkvision_range', 8, 2)->nullable();
      $table->decimal('normal_sight_range', 8, 2)->nullable();
      $table->decimal('blindsight_range', 8, 2)->nullable();
      $table->decimal('tremorsense_range', 8, 2)->nullable();
      $table->decimal('truesight_range', 8, 2)->nullable();
      $table->decimal('telepathy_range', 8, 2)->nullable();

      $table->json('languages')->nullable();
      $table->string('languages_desc')->nullable();
      $table->json('environments')->nullable();

      $table->json('damage_resistances')->nullable();
      $table->json('damage_vulnerabilities')->nullable();
      $table->json('damage_immunities')->nullable();
      $table->json('condition_immunities')->nullable();

      $table->string('damage_resistances_display')->nullable();
      $table->string('damage_vulnerabilities_display')->nullable();
      $table->string('damage_immunities_display')->nullable();
      $table->string('condition_immunities_display')->nullable();

      $table->boolean('nonmagical_attack_immunity')->nullable();
      $table->boolean('nonmagical_attack_resistance')->nullable();

      $table->decimal('weight', 6, 3)->nullable();
      $table->integer('experience_points_integer')->nullable();

      // Saving throws
      $table->integer('saving_throw_strength')->nullable();
      $table->integer('saving_throw_dexterity')->nullable();
      $table->integer('saving_throw_constitution')->nullable();
      $table->integer('saving_throw_intelligence')->nullable();
      $table->integer('saving_throw_wisdom')->nullable();
      $table->integer('saving_throw_charisma')->nullable();

      // Skill bonuses
      $table->json('skill_bonuses')->nullable();

      // Foreign Key
      $table->foreignId('document_id')->constrained()->cascadeOnDelete();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('creatures');
  }
};
