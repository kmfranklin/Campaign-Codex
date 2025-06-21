<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFeatureItem extends Model
{
  protected $table = 'class_feature_items';
  protected $primaryKey = 'key';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'parent',
    'level',
    'column_value',
    'detail',
  ];

  public function feature()
  {
    return $this->belongsTo(ClassFeature::class, 'parent', 'key');
  }
}
