<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feat extends Model
{
  use HasFactory;

  protected $fillable = [
    'key',
    'document_id',
    'name',
    'description',
    'prerequisite',
    'type',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
