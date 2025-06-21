<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('character_classes', function (Blueprint $table) {
      $table->id();

      $table->string('key')->unique();
      $table->foreignId('document_id')->constrained()->onDelete('cascade');

      $table->string('name');
      $table->text('hit_dice')->nullable();
      $table->string('caster_type')->nullable();
      $table->json('primary_abilities')->nullable();
      $table->json('saving_throws')->nullable();

      $table->string('subclass_of')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('character_classes');
  }
};
