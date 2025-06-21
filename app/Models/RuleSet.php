<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleSet extends Model
{
  protected $table = 'rulesets';

  protected $fillable = [
    'key',
    'document_id',
    'name',
    'description',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
