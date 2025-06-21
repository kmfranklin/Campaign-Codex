<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DamageType;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class DamageTypeSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/damage-types');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.damagetype') {
        $this->command->warn("Skipping file: {$file->getFilename()} (unexpected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (DamageType: {$data['pk']})");
        continue;
      }

      DamageType::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id' => $document->id,
          'name'        => $fields['name'] ?? 'Unnamed',
          'description' => $fields['desc'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} damage types from local JSON files.");
  }
}
