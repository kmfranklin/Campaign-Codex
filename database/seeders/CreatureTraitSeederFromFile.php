<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CreatureTrait;

class CreatureTraitSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/creature-traits');

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

      CreatureTrait::updateOrCreate(
        ['key' => $json['pk']],
        [
          'name'   => $fields['name'] ?? '',
          'desc'   => $fields['desc'] ?? '',
          'type'   => $fields['type'] ?? null,
          'parent' => $fields['parent'] ?? '',
        ]
      );

      $count++;
    }

    $this->command->info("CreatureTraits imported successfully. Total: $count");
  }
}
