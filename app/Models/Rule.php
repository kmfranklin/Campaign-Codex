<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
  protected $fillable = [
    'key',
    'document_id',
    'ruleset',
    'name',
    'description',
    'index',
    'initial_header_level',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
