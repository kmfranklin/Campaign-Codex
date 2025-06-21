<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CreatureType;
use App\Models\Document;

class CreatureTypeSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/creature-types');

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
      $documentSlug = $fields['document'] ?? null;

      $document = Document::where('slug', $documentSlug)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: $documentSlug (CreatureType: {$json['pk']})");
        continue;
      }

      CreatureType::updateOrCreate(
        ['key' => $json['pk']],
        [
          'name'        => $fields['name'] ?? '',
          'desc'        => $fields['desc'] ?? '',
          'document_id' => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("CreatureTypes imported successfully. Total: $count");
  }
}
