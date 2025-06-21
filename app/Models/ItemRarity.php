<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRarity extends Model
{
  use HasFactory;

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'name',
    'rank',
    'document_id',
  ];

  public function document()
  {
    return $this->belongsTo(Document::class);
  }
}
