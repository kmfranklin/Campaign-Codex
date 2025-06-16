<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spell extends Model
{
  protected $fillable = [
    'document_id',
    'slug',
    'name',
    'description',
    'higher_level',
    'page',
    'range',
    'target_range_sort',
    'components',
    'requires_verbal_components',
    'requires_somatic_components',
    'requires_material_components',
    'material',
    'can_be_cast_as_ritual',
    'concentration',
    'duration',
    'casting_time',
    'level',
    'level_text',
    'school',
    'classes',
    'spell_lists',
    'archetype',
    'circles',
  ];

  protected $casts = [
    'spell_lists' => 'array',
    'requires_verbal_components' => 'boolean',
    'requires_somatic_components' => 'boolean',
    'requires_material_components' => 'boolean',
    'can_be_cast_as_ritual' => 'boolean',
    'concentration' => 'boolean',
    'level' => 'integer',
    'target_range_sort' => 'integer',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
