<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Rule;
use App\Models\Document;

class RuleSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/rules');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.rule') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Rule: {$data['pk']})");
        continue;
      }

      Rule::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id'          => $document->id,
          'ruleset'              => $fields['ruleset'] ?? null,
          'name'                 => $fields['name'] ?? 'Unnamed',
          'description'          => $fields['desc'] ?? null,
          'index'                => $fields['index'] ?? null,
          'initial_header_level' => $fields['initialHeaderLevel'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} rules from local JSON files.");
  }
}
