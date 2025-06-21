<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('spell_casting_options', function (Blueprint $table) {
      $table->id();
      $table->string('parent'); // Foreign key to the spell (string-based key like "srd_acid-arrow")
      $table->string('type')->nullable();

      $table->text('desc')->nullable();
      $table->boolean('concentration')->nullable();
      $table->string('damage_roll')->nullable();
      $table->string('duration')->nullable();
      $table->string('range')->nullable();
      $table->string('shape_size')->nullable();
      $table->string('target_count')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('spell_casting_options');
  }
};
