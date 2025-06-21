<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('feat_benefits', function (Blueprint $table) {
      $table->id(); // Uses JSON 'pk' as primary key
      $table->string('name')->nullable();
      $table->text('desc')->nullable();
      $table->string('type')->nullable();
      $table->string('parent'); // FK to feats.key
      $table->timestamps();

      $table->foreign('parent')->references('key')->on('feats')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('feat_benefits');
  }
};
