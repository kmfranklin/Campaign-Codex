<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weapon;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class WeaponSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/weapons');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.weapon') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Weapon: {$data['pk']})");
        continue;
      }

      Weapon::updateOrCreate(
        ['name' => $fields['name']],
        [
          'damage_dice'   => $fields['damage_dice'] ?? null,
          'damage_type'   => $fields['damage_type'] ?? null,
          'range'         => $fields['range'] ?? 0,
          'long_range'    => $fields['long_range'] ?? 0,
          'distance_unit' => $fields['distance_unit'] ?? null,
          'is_improvised' => $fields['is_improvised'] ?? false,
          'is_simple'     => $fields['is_simple'] ?? false,
          'document_id'   => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} weapons from local JSON files.");
  }
}
