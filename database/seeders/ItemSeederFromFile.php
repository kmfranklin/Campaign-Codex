<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ItemSeederFromFile extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $itemPath = storage_path('data/srd-2014/items');
    $armorPath = storage_path('data/srd-2014/armor');

    $files = glob($itemPath . '/*.json');
    if (empty($files)) {
      $this->command->warn("No item files found in $itemPath");
      return;
    }

    // Load all armor definitions into memory
    $armorMap = [];
    foreach (glob($armorPath . '/*.json') as $armorFile) {
      $armorJson = json_decode(file_get_contents($armorFile), true);
      if (isset($armorJson['pk'], $armorJson['fields']['ac_base'])) {
        $armorMap[$armorJson['pk']] = $armorJson['fields'];
      }
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

      // Resolve armor_class from armor table if needed
      $resolvedAC = (int)($fields['armor_class'] ?? 0);
      if ($resolvedAC === 0 && isset($fields['armor']) && isset($armorMap[$fields['armor']])) {
        $resolvedAC = (int)($armorMap[$fields['armor']]['ac_base'] ?? 0);
      }

      // Pull armor metadata, if necessary
      $armorStats = null;
      if (isset($fields['armor'], $armorMap[$fields['armor']])) {
        $a = $armorMap[$fields['armor']];
        $armorStats = [
          'ac_base' => $a['ac_base'] ?? null,
          'ac_add_dexmod' => $a['ac_add_dexmod'] ?? null,
          'ac_cap_dexmod' => $a['ac_cap_dexmod'] ?? null,
          'grants_stealth_disadvantage' => $a['grants_stealth_disadvantage'] ?? null,
          'strength_score_required' => $a['strength_score_required'] ?? null,
        ];
      }

      Item::updateOrCreate(
        ['key' => $json['pk']],
        [
          'document_id' => $document->id,
          'key' => $json['pk'],
          'name' => $fields['name'] ?? 'Unnamed',
          'description' => isset($fields['desc']) ? stripcslashes($fields['desc']) : null,
          'cost' => is_numeric($fields['cost'] ?? null) ? (float)$fields['cost'] : null,
          'weight' => is_numeric($fields['weight'] ?? null) ? (float)$fields['weight'] : null,
          'requires_attunement' => (bool)($fields['requires_attunement'] ?? false),
          'nonmagical_attack_resistance' => (bool)($fields['nonmagical_attack_resistance'] ?? false),
          'nonmagical_attack_immunity' => (bool)($fields['nonmagical_attack_immunity'] ?? false),
          'armor_class' => $resolvedAC,
          'armor_stats' => $armorStats ? json_encode($armorStats) : null,
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
