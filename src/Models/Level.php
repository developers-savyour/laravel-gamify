<?php

namespace QCod\Gamify\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('gamify.payee_model'), 'user_levels')
            ->withTimestamps();
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class,'badge_id');
    }

    /**
     * Award badge to a user
     *
     * @param $user
     */
    public function awardTo($user)
    {
        $this->users()->attach($user);
    }

    /**
     * Remove badge from user
     *
     * @param $user
     */
    public function removeFrom($user)
    {
        $this->users()->detach($user);
    }

    public function getIconAttribute($value)
    {
        return config('app.app_url'). $value;
    }
}
