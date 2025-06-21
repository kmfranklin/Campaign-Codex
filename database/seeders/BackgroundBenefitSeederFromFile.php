<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackgroundBenefit;
use Illuminate\Support\Facades\File;

class BackgroundBenefitSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/background_benefits');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['fields']) || $data['model'] !== 'api_v2.backgroundbenefit') {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $data['fields'];

      BackgroundBenefit::updateOrCreate(
        ['name' => $fields['name']],
        [
          'description' => $fields['desc'] ?? null,
          'parent_key' => $fields['parent'] ?? null,
          'type'       => $fields['type'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("Imported {$count} background benefits from local JSON files.");
  }
}
