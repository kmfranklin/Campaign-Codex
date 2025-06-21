<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
  use HasFactory;

  protected $fillable = [
    'key',
    'document_id',
    'name',
    'description',
    'is_exotic',
    'is_secret',
    'script_language',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
