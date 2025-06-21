<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('weapon_property_assignments', function (Blueprint $table) {
      $table->string('key')->primary();
      $table->string('weapon');
      $table->string('property');
      $table->string('detail')->nullable();
      $table->timestamps();

      $table->foreign('weapon')->references('key')->on('weapons')->onDelete('cascade');
      $table->foreign('property')->references('key')->on('weapon_properties')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('weapon_property_assignments');
  }
};
