<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFeature extends Model
{
  protected $fillable = [
    'key',
    'document_id',
    'name',
    'description',
    'parent',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
