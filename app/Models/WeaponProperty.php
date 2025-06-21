<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponProperty extends Model
{
  protected $fillable = [
    'name',
    'description',
    'type',
    'document_id',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
