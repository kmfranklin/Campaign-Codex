<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\FeatBenefit;

class FeatBenefitSeederFromFile extends Seeder
{
  public function run(): void
  {
    $path = base_path('data/featbenefits.json');
    if (!File::exists($path)) {
      $this->command->error('File not found: featbenefits.json');
      return;
    }

    $data = json_decode(File::get($path), true);

    foreach ($data as $json) {
      $fields = $json['fields'];

      FeatBenefit::updateOrCreate(
        ['id' => $json['pk']],
        [
          'name' => $fields['name'] ?? null,
          'desc' => $fields['desc'] ?? null,
          'type' => $fields['type'] ?? null,
          'parent' => $fields['parent'] ?? null,
        ]
      );
    }

    $this->command->info('FeatBenefits seeded successfully.');
  }
}
