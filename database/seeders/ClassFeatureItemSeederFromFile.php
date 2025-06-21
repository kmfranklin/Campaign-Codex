<?php

namespace Database\Seeders;

use App\Models\ClassFeatureItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ClassFeatureItemSeederFromFile extends Seeder
{
  public function run(): void
  {
    $path = base_path('storage/data/srd-2014/class-feature-items');

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

      ClassFeatureItem::updateOrCreate(
        ['key' => $data['pk']],
        [
          'level' => $data['fields']['level'],
          'detail' => $data['fields']['detail'],
          'column_value' => $data['fields']['column_value'],
          'parent' => $data['fields']['parent'],
        ]
      );

      $bar->advance();
    }

    $bar->finish();
    $this->command->newLine(2);
    $this->command->info('ClassFeatureItem seeding complete.');
  }
}
