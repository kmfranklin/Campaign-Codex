<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatBenefit extends Model
{
  protected $fillable = [
    'name',
    'desc',
    'type',
    'parent',
  ];

  public function feat()
  {
    return $this->belongsTo(Feat::class, 'parent', 'key');
  }
}
