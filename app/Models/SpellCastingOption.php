<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpellCastingOption extends Model
{
  protected $fillable = [
    'parent',
    'type',
    'desc',
    'concentration',
    'damage_roll',
    'duration',
    'range',
    'shape_size',
    'target_count',
  ];

  protected $casts = [
    'concentration' => 'boolean',
  ];
}
