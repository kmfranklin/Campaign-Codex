<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
  protected $fillable = [
    'key',
    'document_id',
    'name',
    'rank',
    'suggested_hit_dice',
    'space_diameter',
    'distance_unit',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
