<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpellCastingOption;
use Illuminate\Support\Facades\File;

class SpellCastingOptionSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/spellcastingoptions');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.spellcastingoption') {
        $this->command->warn("Skipping file: {$file->getFilename()} (invalid structure)");
        continue;
      }

      $fields = $data['fields'];

      SpellCastingOption::updateOrCreate(
        ['id' => $data['pk']],
        [
          'parent'        => $fields['parent'] ?? '',
          'type'          => $fields['type'] ?? null,
          'desc'          => $fields['desc'] ?? null,
          'concentration' => $fields['concentration'] ?? null,
          'damage_roll'   => $fields['damage_roll'] ?? null,
          'duration'      => $fields['duration'] ?? null,
          'range'         => $fields['range'] ?? null,
          'shape_size'    => $fields['shape_size'] ?? null,
          'target_count'  => $fields['target_count'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} spellcasting options.");
  }
}
