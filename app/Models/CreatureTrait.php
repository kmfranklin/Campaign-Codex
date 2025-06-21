<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreatureTrait extends Model
{
  use HasFactory;

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'name',
    'desc',
    'type',
    'parent',
  ];

  public function creature()
  {
    return $this->belongsTo(Creature::class, 'parent', 'id');
  }
}
