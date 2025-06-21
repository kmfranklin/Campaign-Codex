<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Item;
use App\Models\ItemSet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ItemSetSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/item-sets');

    if (!File::exists($directory)) {
      $this->command->error("Directory not found: $directory");
      return;
    }

    $files = File::files($directory);
    $count = 0;

    foreach ($files as $file) {
      $json = json_decode(File::get($file), true);

      if (!isset($json['fields']) || !isset($json['pk'])) {
        $this->command->warn("Skipping malformed file: {$file->getFilename()}");
        continue;
      }

      $fields = $json['fields'];
      $document = Document::where('slug', $fields['document'] ?? null)->first();

      if (!$document) {
        $this->command->warn("Document not found: {$fields['document']}");
        continue;
      }

      $itemSet = ItemSet::updateOrCreate(
        ['key' => $json['pk']],
        [
          'name' => $fields['name'] ?? '',
          'desc' => $fields['desc'] ?? null,
          'document_id' => $document->id,
        ]
      );

      $itemKeys = $fields['items'] ?? [];
      $validItemKeys = Item::whereIn('key', $itemKeys)->pluck('key')->all();

      $itemSet->items()->sync($validItemKeys);

      $count++;
    }

    $this->command->info("ItemSets imported successfully. Total: $count");
  }
}
