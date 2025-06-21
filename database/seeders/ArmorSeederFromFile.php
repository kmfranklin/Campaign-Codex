<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Armor;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class ArmorSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/armor');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.armor') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Armor: {$data['pk']})");
        continue;
      }

      Armor::updateOrCreate(
        ['name' => $fields['name']],
        [
          'ac_base' => $fields['ac_base'] ?? 0,
          'ac_add_dexmod' => $fields['ac_add_dexmod'] ?? false,
          'ac_cap_dexmod' => $fields['ac_cap_dexmod'] ?? null,
          'strength_score_required' => $fields['strength_score_required'] ?? null,
          'grants_stealth_disadvantage' => $fields['grants_stealth_disadvantage'] ?? false,
          'document_id' => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} armor entries from local JSON files.");
  }
}
