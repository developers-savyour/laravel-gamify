<?php

namespace QCod\Gamify\Models;

use Illuminate\Database\Eloquent\Model;

class ReputationPoint extends Model
{
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
