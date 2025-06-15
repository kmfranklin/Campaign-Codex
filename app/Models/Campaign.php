<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  public function owner()
  {
    return $this->belongsTo(User::class, 'owner_id');
  }

  public function members()
  {
    return $this->belongsToMany(User::class)
      ->withPivot('role', 'joined_at')
      ->withTimestamps();
  }

  public function players()
  {
    return $this->members()->wherePivot('role', 'player');
  }

  public function dungeonMaster()
  {
    return $this->members()->wherePivot('role', 'dm');
  }
}
