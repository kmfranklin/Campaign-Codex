<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CreatureAction;

class CreatureActionSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/creature-actions');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: $directory");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $json = json_decode(File::get($file), true);

      if (!isset($json['fields']) || !isset($json['pk'])) {
        $this->command->warn("Skipping file: {$file->getFilename()} (missing expected structure)");
        continue;
      }

      $fields = $json['fields'];

      CreatureAction::updateOrCreate(
        ['key' => $json['pk']],
        [
          'name'            => $fields['name'] ?? '',
          'desc'            => $fields['desc'] ?? '',
          'action_type'     => $fields['action_type'] ?? null,
          'form_condition'  => $fields['form_condition'] ?? null,
          'legendary_cost'  => $fields['legendary_cost'] ?? null,
          'order'           => $fields['order'] ?? null,
          'uses_type'       => $fields['uses_type'] ?? null,
          'uses_param'      => $fields['uses_param'] ?? null,
          'parent'          => $fields['parent'] ?? '',
        ]
      );

      $count++;
    }

    $this->command->info("CreatureActions imported successfully. Total: $count");
  }
}
