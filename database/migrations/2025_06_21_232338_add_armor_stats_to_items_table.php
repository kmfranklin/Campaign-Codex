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
    Schema::table('items', function (Blueprint $table) {
      $table->json('armor_stats')->nullable()->after('armor_class');
    });
  }

  public function down(): void
  {
    Schema::table('items', function (Blueprint $table) {
      $table->dropColumn('armor_stats');
    });
  }
};
