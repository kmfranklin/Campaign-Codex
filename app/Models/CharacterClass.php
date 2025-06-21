<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
  protected $fillable = [
    'key',
    'document_id',
    'name',
    'hit_dice',
    'caster_type',
    'primary_abilities',
    'saving_throws',
    'subclass_of',
  ];

  protected $casts = [
    'primary_abilities' => 'array',
    'saving_throws' => 'array',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
