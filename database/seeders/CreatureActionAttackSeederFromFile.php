<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CreatureActionAttack;

class CreatureActionAttackSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/creature-action-attacks');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: $directory");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $json = json_decode(File::get($file), true);

      if (!isset($json['fields']) || !isset($json['pk'])) {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $json['fields'];

      CreatureActionAttack::updateOrCreate(
        ['key' => $json['pk']],
        [
          'name' => $fields['name'] ?? '',
          'attack_type' => $fields['attack_type'] ?? null,
          'to_hit_mod' => $fields['to_hit_mod'] ?? null,
          'reach' => $fields['reach'] ?? null,
          'range' => $fields['range'] ?? null,
          'long_range' => $fields['long_range'] ?? null,
          'distance_unit' => $fields['distance_unit'] ?? null,
          'target_creature_only' => $fields['target_creature_only'] ?? false,
          'damage_die_count' => $fields['damage_die_count'] ?? null,
          'damage_die_type' => $fields['damage_die_type'] ?? null,
          'damage_type' => $fields['damage_type'] ?? null,
          'damage_bonus' => $fields['damage_bonus'] ?? null,
          'extra_damage_die_count' => $fields['extra_damage_die_count'] ?? null,
          'extra_damage_die_type' => $fields['extra_damage_die_type'] ?? null,
          'extra_damage_type' => $fields['extra_damage_type'] ?? null,
          'extra_damage_bonus' => $fields['extra_damage_bonus'] ?? null,
          'parent' => $fields['parent'] ?? '',
        ]
      );

      $count++;
    }

    $this->command->info("CreatureActionAttacks imported successfully. Total: $count");
  }
}
