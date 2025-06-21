<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeaponPropertyAssignment extends Model
{
  protected $table = 'weapon_property_assignments';

  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'weapon',
    'property',
    'detail',
  ];

  public function weapon(): BelongsTo
  {
    return $this->belongsTo(Weapon::class, 'weapon', 'key');
  }

  public function property(): BelongsTo
  {
    return $this->belongsTo(WeaponProperty::class, 'property', 'key');
  }
}
