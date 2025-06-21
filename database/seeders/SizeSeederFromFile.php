<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;
use App\Models\Document;
use Illuminate\Support\Facades\File;

class SizeSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/sizes');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.size') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: {$fields['document']} (Size: {$data['pk']})");
        continue;
      }

      Size::updateOrCreate(
        ['key' => $data['pk']],
        [
          'document_id'        => $document->id,
          'name'               => $fields['name'] ?? 'Unnamed',
          'rank'               => $fields['rank'] ?? null,
          'suggested_hit_dice' => $fields['suggested_hit_dice'] ?? null,
          'space_diameter'     => $fields['space_diameter'] ?? null,
          'distance_unit'      => $fields['distance_unit'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} sizes from local JSON files.");
  }
}
