<?php

namespace QCod\Gamify\Traits;

use QCod\Gamify\Models\Level;

trait HasLevels
{
    /**
     * Badges user relation
     *
     * @return mixed
     */
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'user_levels')
            ->withTimestamps();
    }

    /**
     * Sync badges for qiven user
     *
     * @param $user
     */
    public function syncLevels($user = null)
    {
        $user = is_null($user) ? $this : $user;
        $levelIds = app('levels')->filter
            ->qualifier($user)
            ->map->getLevelId();
        $user->levels()->sync($levelIds);

        if(!empty($user->levels->last()->badge))
        {
            $user->badge_id =   $user->levels->last()->badge->id;
        }

        if($user->levels->last()->id)
        {
            $user->level_id =   $user->levels->last()->id;
        }

        $user->save();
    }
}
