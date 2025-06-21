<?php

namespace Database\Seeders;

use App\Models\WeaponPropertyAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WeaponPropertyAssignmentSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = base_path('storage/data/srd-2014/weapon-property-assignments');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: {$directory}");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $data = json_decode(File::get($file), true);

      if (!isset($data['pk'], $data['fields'])) {
        $this->command->warn("Invalid file skipped: {$file->getFilename()}");
        continue;
      }

      WeaponPropertyAssignment::updateOrCreate(
        ['key' => $data['pk']],
        [
          'weapon' => $data['fields']['weapon'],
          'property' => $data['fields']['property'],
          'detail' => $data['fields']['detail'] ?? null,
        ]
      );

      $count++;
    }

    $this->command->info("WeaponPropertyAssignmentSeederFromFile complete: {$count} records seeded.");
  }
}
