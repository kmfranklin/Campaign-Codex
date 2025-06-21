<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreatureAction extends Model
{
  use HasFactory;

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'name',
    'action_type',
    'desc',
    'form_condition',
    'legendary_cost',
    'order',
    'uses_type',
    'uses_param',
    'parent',
  ];

  public function creature()
  {
    return $this->belongsTo(Creature::class, 'parent', 'id');
  }
}
