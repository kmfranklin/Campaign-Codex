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
    Schema::create('spells', function (Blueprint $table) {
      $table->id();

      // Foreign key to documents
      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      // Core fields from Open5e
      $table->string('slug')->unique();
      $table->string('name');
      $table->text('description')->nullable(); // from 'desc'
      $table->text('higher_level')->nullable();
      $table->string('page')->nullable();
      $table->string('range')->nullable();
      $table->integer('target_range_sort')->nullable();

      // Components and material
      $table->string('components')->nullable(); // e.g. V, S, M
      $table->boolean('requires_verbal_components')->default(false);
      $table->boolean('requires_somatic_components')->default(false);
      $table->boolean('requires_material_components')->default(false);
      $table->text('material')->nullable();

      // Ritual & Concentration (normalized)
      $table->boolean('can_be_cast_as_ritual')->default(false);
      $table->boolean('concentration')->default(false);

      $table->string('duration')->nullable();
      $table->string('casting_time')->nullable();

      // Spell level and school
      $table->tinyInteger('level')->nullable(); // numeric
      $table->string('level_text')->nullable(); // e.g. '2nd-level'
      $table->string('school')->nullable();

      // Class and archetype info
      $table->string('classes')->nullable(); // flat string e.g. "Wizard, Druid"
      $table->json('spell_lists')->nullable(); // normalized version as array
      $table->string('archetype')->nullable();
      $table->string('circles')->nullable();

      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('spells');
  }
};
