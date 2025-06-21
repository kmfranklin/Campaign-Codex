<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Creature;
use App\Models\Document;

class CreatureSeederFromFile extends Seeder
{
  public function run(): void
  {
    $directory = storage_path('data/srd-2014/creatures');

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
      $documentSlug = $fields['document'] ?? null;
      $document = Document::where('slug', $documentSlug)->first();

      if (!$document) {
        $this->command->warn("Document not found for slug: $documentSlug (Creature: {$json['pk']})");
        continue;
      }

      // Extract skill bonuses
      $skills = [];
      foreach ($fields as $key => $value) {
        if (str_starts_with($key, 'skill_bonus_') && $value !== null) {
          $skill = substr($key, strlen('skill_bonus_'));
          $skills[$skill] = $value;
        }
      }

      Creature::updateOrCreate(
        ['id' => $json['pk']],
        [
          // explicitly list fields, EXCLUDING 'document'
          'name' => $fields['name'] ?? '',
          'type' => $fields['type'] ?? null,
          'size' => $fields['size'] ?? null,
          'alignment' => $fields['alignment'] ?? null,
          'category' => $fields['category'] ?? null,
          'subcategory' => $fields['subcategory'] ?? null,
          'armor_detail' => $fields['armor_detail'] ?? null,
          'armor_class' => $fields['armor_class'] ?? null,
          'hit_dice' => $fields['hit_dice'] ?? null,
          'hit_points' => $fields['hit_points'] ?? null,
          'challenge_rating_decimal' => $fields['challenge_rating_decimal'] ?? null,
          'passive_perception' => $fields['passive_perception'] ?? null,
          'proficiency_bonus' => $fields['proficiency_bonus'] ?? null,
          'walk' => $fields['walk'] ?? null,
          'climb' => $fields['climb'] ?? null,
          'fly' => $fields['fly'] ?? null,
          'swim' => $fields['swim'] ?? null,
          'burrow' => $fields['burrow'] ?? null,
          'hover' => $fields['hover'] ?? null,
          'ability_score_strength' => $fields['ability_score_strength'] ?? null,
          'ability_score_dexterity' => $fields['ability_score_dexterity'] ?? null,
          'ability_score_constitution' => $fields['ability_score_constitution'] ?? null,
          'ability_score_intelligence' => $fields['ability_score_intelligence'] ?? null,
          'ability_score_wisdom' => $fields['ability_score_wisdom'] ?? null,
          'ability_score_charisma' => $fields['ability_score_charisma'] ?? null,
          'initiative_bonus' => $fields['initiative_bonus'] ?? null,
          'darkvision_range' => $fields['darkvision_range'] ?? null,
          'normal_sight_range' => $fields['normal_sight_range'] ?? null,
          'blindsight_range' => $fields['blindsight_range'] ?? null,
          'tremorsense_range' => $fields['tremorsense_range'] ?? null,
          'truesight_range' => $fields['truesight_range'] ?? null,
          'telepathy_range' => $fields['telepathy_range'] ?? null,
          'languages' => $fields['languages'] ?? [],
          'languages_desc' => $fields['languages_desc'] ?? null,
          'environments' => $fields['environments'] ?? [],
          'damage_resistances' => $fields['damage_resistances'] ?? [],
          'damage_vulnerabilities' => $fields['damage_vulnerabilities'] ?? [],
          'damage_immunities' => $fields['damage_immunities'] ?? [],
          'condition_immunities' => $fields['condition_immunities'] ?? [],
          'damage_resistances_display' => $fields['damage_resistances_display'] ?? null,
          'damage_vulnerabilities_display' => $fields['damage_vulnerabilities_display'] ?? null,
          'damage_immunities_display' => $fields['damage_immunities_display'] ?? null,
          'condition_immunities_display' => $fields['condition_immunities_display'] ?? null,
          'nonmagical_attack_immunity' => $fields['nonmagical_attack_immunity'] ?? null,
          'nonmagical_attack_resistance' => $fields['nonmagical_attack_resistance'] ?? null,
          'weight' => $fields['weight'] ?? null,
          'experience_points_integer' => $fields['experience_points_integer'] ?? null,
          'saving_throw_strength' => $fields['saving_throw_strength'] ?? null,
          'saving_throw_dexterity' => $fields['saving_throw_dexterity'] ?? null,
          'saving_throw_constitution' => $fields['saving_throw_constitution'] ?? null,
          'saving_throw_intelligence' => $fields['saving_throw_intelligence'] ?? null,
          'saving_throw_wisdom' => $fields['saving_throw_wisdom'] ?? null,
          'saving_throw_charisma' => $fields['saving_throw_charisma'] ?? null,
          'skill_bonuses' => $skills,
          'document_id' => $document->id,
        ]
      );

      $count++;
    }

    $this->command->info("Creatures imported successfully. Total: $count");
  }
}
