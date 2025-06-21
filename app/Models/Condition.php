<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
  protected $fillable = [
    'document_id',
    'key',
    'name',
    'description',
    'icon',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
