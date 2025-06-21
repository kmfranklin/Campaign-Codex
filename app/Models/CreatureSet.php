<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreatureSet extends Model
{
  use HasFactory;

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'name',
    'creatures',
    'document_id',
  ];

  protected $casts = [
    'creatures' => 'array',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
