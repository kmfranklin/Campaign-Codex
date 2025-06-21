<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
  protected $fillable = [
    'name',
    'description',
    'ability',
    'document_id',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
