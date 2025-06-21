<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeaponProperty;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class WeaponPropertySeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/weapon_properties');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.weaponproperty') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (WeaponProperty: {$data['pk']})");
        continue;
      }

      WeaponProperty::updateOrCreate(
        ['name' => $fields['name']],
        [
          'description' => $fields['desc'] ?? null,
          'type'        => $fields['type'] ?? null,
          'document_id' => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} weapon properties from local JSON files.");
  }
}
