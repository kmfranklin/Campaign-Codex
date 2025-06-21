<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
  protected $table = 'armor';

  protected $fillable = [
    'name',
    'ac_base',
    'ac_add_dexmod',
    'ac_cap_dexmod',
    'strength_score_required',
    'grants_stealth_disadvantage',
    'document_id',
  ];

  protected $casts = [
    'ac_base' => 'integer',
    'ac_add_dexmod' => 'boolean',
    'ac_cap_dexmod' => 'integer',
    'strength_score_required' => 'integer',
    'grants_stealth_disadvantage' => 'boolean',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
