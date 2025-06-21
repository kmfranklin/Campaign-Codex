<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreatureActionAttack extends Model
{
  use HasFactory;

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'name',
    'attack_type',
    'to_hit_mod',
    'reach',
    'range',
    'long_range',
    'distance_unit',
    'target_creature_only',
    'damage_die_count',
    'damage_die_type',
    'damage_type',
    'damage_bonus',
    'extra_damage_die_count',
    'extra_damage_die_type',
    'extra_damage_type',
    'extra_damage_bonus',
    'parent',
  ];

  protected $casts = [
    'target_creature_only' => 'boolean',
  ];

  public function action()
  {
    return $this->belongsTo(CreatureAction::class, 'parent', 'key');
  }
}
