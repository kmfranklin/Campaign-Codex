<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Background;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class BackgroundSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/backgrounds');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.background') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Background: {$data['pk']})");
        continue;
      }

      Background::updateOrCreate(
        ['name' => $fields['name']],
        [
          'description' => $fields['desc'] ?? null,
          'document_id' => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} backgrounds from local JSON files.");
  }
}
