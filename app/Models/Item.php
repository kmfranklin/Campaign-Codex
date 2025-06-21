<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $fillable = [
    'document_id',
    'key',
    'name',
    'description',
    'is_magic_item',
    'cost',
    'weight',
    'requires_attunement',
    'nonmagical_attack_resistance',
    'nonmagical_attack_immunity',
    'armor_class',
    'hit_points',
    'hit_dice',
    'category',
    'size',
    'damage_vulnerabilities',
    'damage_immunities',
    'damage_resistances',
    'armor',
    'armor_detail',
    'weapon',
    'rarity',
  ];

  protected $casts = [
    'is_magic_item' => 'boolean',
    'requires_attunement' => 'boolean',
    'nonmagical_attack_resistance' => 'boolean',
    'nonmagical_attack_immunity' => 'boolean',
    'cost' => 'float',
    'weight' => 'float',
    'armor_class' => 'integer',
    'hit_points' => 'integer',
    'damage_vulnerabilities' => 'array',
    'damage_immunities' => 'array',
    'damage_resistances' => 'array',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
