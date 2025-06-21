<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creature extends Model
{

  protected $primaryKey = 'id';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'id',
    'name',
    'type',
    'size',
    'alignment',
    'category',
    'subcategory',
    'armor_detail',
    'armor_class',
    'hit_dice',
    'hit_points',
    'challenge_rating_decimal',
    'passive_perception',
    'proficiency_bonus',
    'walk',
    'climb',
    'fly',
    'swim',
    'hover',
    'ability_score_strength',
    'ability_score_dexterity',
    'ability_score_constitution',
    'ability_score_intelligence',
    'ability_score_wisdom',
    'ability_score_charisma',
    'initiative_bonus',
    'darkvision_range',
    'normal_sight_range',
    'blindsight_range',
    'tremorsense_range',
    'truesight_range',
    'telepathy_range',
    'languages',
    'languages_desc',
    'environments',
    'damage_resistances',
    'damage_vulnerabilities',
    'damage_immunities',
    'condition_immunities',
    'damage_resistances_display',
    'damage_vulnerabilities_display',
    'damage_immunities_display',
    'condition_immunities_display',
    'nonmagical_attack_immunity',
    'nonmagical_attack_resistance',
    'weight',
    'experience_points_integer',
    'saving_throw_strength',
    'saving_throw_dexterity',
    'saving_throw_constitution',
    'saving_throw_intelligence',
    'saving_throw_wisdom',
    'saving_throw_charisma',
    'skill_bonuses',
    'document_id',
  ];

  protected $casts = [
    'languages' => 'array',
    'environments' => 'array',
    'damage_resistances' => 'array',
    'damage_vulnerabilities' => 'array',
    'damage_immunities' => 'array',
    'condition_immunities' => 'array',
    'hover' => 'boolean',
    'nonmagical_attack_immunity' => 'boolean',
    'nonmagical_attack_resistance' => 'boolean',
    'skill_bonuses' => 'array',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
