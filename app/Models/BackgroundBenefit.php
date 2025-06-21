<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundBenefit extends Model
{
  protected $fillable = [
    'name',
    'description',
    'parent_key',
    'type',
  ];
}
