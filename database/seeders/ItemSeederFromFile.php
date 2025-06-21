<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemSeederFromFile extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $path = storage_path('data/srd-2014/items');
    $files = glob($path . '/*.json');

    if (empty($files)) {
      $this->command->warn('No item files found in ' . $path);
      return;
    }

    foreach ($files as $file) {
      $json = json_decode(file_get_contents($file), true);

      if (!isset($json['fields']) || !isset($json['pk'])) {
        $this->command->warn("Skipping file: $file (missing expected structure)");
        continue;
      }

      $fields = $json['fields'];
      $documentSlug = $fields['document'] ?? null;

      if (!$documentSlug) {
        $this->command->warn("Skipping item {$json['pk']} due to missing document slug.");
        continue;
      }

      $document = Document::where('slug', $documentSlug)->first();
      if (!$document) {
        $this->command->warn("Document not found for slug: $documentSlug (Item: {$json['pk']})");
        continue;
      }

      Item::updateOrCreate(
        ['key' => $json['pk']],
        [
          'document_id' => $document->id,
          'key' => $json['pk'],
          'name' => $fields['name'] ?? 'Unnamed',
          'description' => $fields['desc'] ?? null,
          'is_magic_item' => false, // Not in local JSON
          'cost' => is_numeric($fields['cost']) ? (float)$fields['cost'] : null,
          'weight' => is_numeric($fields['weight']) ? (float)$fields['weight'] : null,
          'requires_attunement' => (bool)($fields['requires_attunement'] ?? false),
          'nonmagical_attack_resistance' => (bool)($fields['nonmagical_attack_resistance'] ?? false),
          'nonmagical_attack_immunity' => (bool)($fields['nonmagical_attack_immunity'] ?? false),
          'armor_class' => (int)($fields['armor_class'] ?? 0),
          'hit_points' => (int)($fields['hit_points'] ?? 0),
          'hit_dice' => $fields['hit_dice'] ?? null,
          'category' => $fields['category'] ?? null,
          'size' => $fields['size'] ?? null,
          'damage_vulnerabilities' => json_encode($fields['damage_vulnerabilities'] ?? []),
          'damage_immunities' => json_encode($fields['damage_immunities'] ?? []),
          'damage_resistances' => json_encode($fields['damage_resistances'] ?? []),
          'armor' => $fields['armor'] ?? null,
          'armor_detail' => $fields['armor_detail'] ?? null,
          'weapon' => $fields['weapon'] ?? null,
          'rarity' => $fields['rarity'] ?? null,
        ]
      );
    }

    $this->command->info('Items imported successfully from local JSON files.');
  }
}
