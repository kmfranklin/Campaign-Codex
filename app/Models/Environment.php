<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
  protected $primaryKey = 'slug';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'slug',
    'name',
    'aquatic',
    'interior',
    'planar',
    'desc',
    'document_id',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
