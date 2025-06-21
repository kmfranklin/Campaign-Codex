<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
  protected $fillable = [
    'name',
    'damage_dice',
    'damage_type',
    'range',
    'long_range',
    'distance_unit',
    'is_improvised',
    'is_simple',
    'document_id',
  ];

  protected $casts = [
    'range' => 'float',
    'long_range' => 'float',
    'is_improvised' => 'boolean',
    'is_simple' => 'boolean',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
