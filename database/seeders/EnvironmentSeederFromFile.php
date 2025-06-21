<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Environment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EnvironmentSeederFromFile extends Seeder
{
  public function run(): void
  {
    $path = base_path('storage/data/srd-2014/environments');

    if (!File::exists($path)) {
      $this->command->error("Directory not found: {$path}");
      return;
    }

    $files = File::files($path);
    $bar = $this->command->getOutput()->createProgressBar(count($files));
    $bar->start();

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);
      if (!isset($data['fields'], $data['pk'])) continue;

      $docSlug = $data['fields']['document'];
      $document = Document::where('slug', $docSlug)->first();
      if (!$document) continue;

      Environment::updateOrCreate(
        ['slug' => $data['pk']],
        [
          'name' => $data['fields']['name'],
          'desc' => $data['fields']['desc'],
          'aquatic' => $data['fields']['aquatic'],
          'interior' => $data['fields']['interior'],
          'planar' => $data['fields']['planar'],
          'document_id' => $document->id,
        ]
      );

      $bar->advance();
    }

    $bar->finish();
    $this->command->newLine(2);
    $this->command->info('Environment seeding complete.');
  }
}
