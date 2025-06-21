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
    Schema::create('items', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->string('key')->unique();
      $table->string('name');
      $table->text('description')->nullable();
      $table->boolean('is_magic_item')->default(false);
      $table->decimal('cost', 8, 2)->nullable();
      $table->decimal('weight', 8, 2)->nullable();

      $table->boolean('requires_attunement')->default(false);
      $table->boolean('nonmagical_attack_resistance')->default(false);
      $table->boolean('nonmagical_attack_immunity')->default(false);

      $table->unsignedTinyInteger('armor_class')->default(0);
      $table->unsignedSmallInteger('hit_points')->default(0);
      $table->string('hit_dice')->nullable();

      $table->string('category')->nullable();
      $table->string('size')->nullable();

      $table->json('damage_vulnerabilities')->nullable();
      $table->json('damage_immunities')->nullable();
      $table->json('damage_resistances')->nullable();

      $table->string('armor')->nullable();
      $table->string('armor_detail')->nullable();
      $table->string('weapon')->nullable();
      $table->string('rarity')->nullable();

      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('items');
  }
};
