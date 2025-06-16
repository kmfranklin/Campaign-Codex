<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  protected $fillable = [
    'title',
    'slug',
    'url',
    'license',
    'description',
    'author',
    'organization',
    'version',
    'copyright',
    'license_url',
    'v2_related_key',
  ];
}
