<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
  protected $fillable = [
    'name',
    'description',
    'document_id',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
