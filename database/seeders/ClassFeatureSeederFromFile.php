<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassFeature;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class ClassFeatureSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/class_features');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.classfeature') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (ClassFeature: {$data['pk']})");
        continue;
      }

      ClassFeature::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id' => $document->id,
          'name'        => $fields['name'] ?? 'Unnamed',
          'description' => $fields['desc'] ?? null,
          'parent'      => $fields['parent'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} class features from local JSON files.");
  }
}
