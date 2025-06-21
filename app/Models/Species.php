<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
  protected $fillable = [
    'key',
    'name',
    'description',
    'document_id',
    'subspecies_of',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
