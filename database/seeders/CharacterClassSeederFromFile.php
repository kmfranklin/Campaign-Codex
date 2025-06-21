<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CharacterClass;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class CharacterClassSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/character_classes');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.characterclass') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (CharacterClass: {$data['pk']})");
        continue;
      }

      CharacterClass::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id'      => $document->id,
          'name'             => $fields['name'] ?? 'Unnamed',
          'hit_dice'         => $fields['hit_dice'] ?? null,
          'caster_type'      => $fields['caster_type'] ?? null,
          'primary_abilities' => $fields['primary_abilities'] ?? [],
          'saving_throws'    => $fields['saving_throws'] ?? [],
          'subclass_of'      => $fields['subclass_of'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} character classes from local JSON files.");
  }
}
