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
    Schema::create('campaign_user', function (Blueprint $table) {
      $table->id();
      $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->enum('role', ['dm', 'player']);
      $table->timestamp('joined_at')->nullable();
      $table->timestamps();

      $table->unique(['campaign_id', 'user_id']); // prevent duplicate memberships
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('campaign_user');
  }
};
