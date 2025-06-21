<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
  use HasFactory;

  protected $fillable = [
    'key',
    'document_id',
    'name',
    'short_description',
    'description',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
