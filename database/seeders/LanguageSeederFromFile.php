<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class LanguageSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/languages');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.language') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Language: {$data['pk']})");
        continue;
      }

      Language::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id'     => $document->id,
          'name'            => $fields['name'] ?? 'Unnamed',
          'description'     => $fields['desc'] ?? null,
          'is_exotic'       => $fields['is_exotic'] ?? false,
          'is_secret'       => $fields['is_secret'] ?? false,
          'script_language' => $fields['script_language'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} languages from local JSON files.");
  }
}
