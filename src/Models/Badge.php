<?php

namespace QCod\Gamify\Models;

use App\Models\Level;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function levels()
    {
        return $this->hasMany(Level::class,'badge_id');
    }

    public function getIconAttribute($value)
    {
        return config('app.app_url'). $value;
    }
}
