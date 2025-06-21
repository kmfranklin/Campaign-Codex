<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('armor', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedTinyInteger('ac_base')->default(0);
      $table->boolean('ac_add_dexmod')->default(false);
      $table->unsignedTinyInteger('ac_cap_dexmod')->nullable();
      $table->unsignedTinyInteger('strength_score_required')->nullable();
      $table->boolean('grants_stealth_disadvantage')->default(false);

      $table->unsignedBigInteger('document_id');
      $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('armor');
  }
};
