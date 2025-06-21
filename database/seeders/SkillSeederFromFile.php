<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class SkillSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/skills');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || !isset($data['model']) || $data['model'] !== 'api_v2.skill') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $documentSlug = $fields['document'] ?? null;

      $document = Document::where('slug', $documentSlug)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$documentSlug} (Skill: {$data['pk']})");
        continue;
      }

      Skill::updateOrCreate(
        ['name' => $fields['name'] ?? 'Unnamed'],
        [
          'document_id' => $document->id,
          'description' => $fields['desc'] ?? null,
          'ability' => $fields['ability'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} skills from local JSON files.");
  }
}
