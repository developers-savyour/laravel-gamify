<?php

namespace QCod\Gamify\Classes;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use QCod\Gamify\Models\Level;

abstract class LevelType
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BadgeType constructor.
     */
    public function __construct()
    {
        $this->model = $this->storeLevel();
    }

    /**
     * Check if user qualifies for this badge
     *
     * @param $user
     * @return bool
     */
    abstract public function qualifier($user);

    /**
     * Get name of badge
     *
     * @return string
     */
    public function getName()
    {
        return property_exists($this, 'name')
            ? $this->name
            : $this->getDefaultLevelName();
    }

    /**
     * Get description of badge
     *
     * @return string
     */
    public function getDescription()
    {
        return isset($this->description)
            ? $this->description
            : '';
    }

    /**
     * Get the icon for badge
     *
     * @return string
     */
    public function getIcon()
    {
        return property_exists($this, 'icon')
            ? $this->icon
            : $this->getDefaultIcon();
    }

    /**
     * Get the level for badge
     *
     * @return int
     */
    public function getBadge()
    {
        $badge = property_exists($this, 'badge')
            ? $this->badge
            : config('gamify.level_default_badge', 1);

        if (is_numeric($badge)) {
            return $badge;
        }
    }

    /**
     * Get badge id
     *
     * @return mixed
     */
    public function getLevelId()
    {
        return $this->model->getKey();
    }

    /**
     * Get the default name if not provided
     *
     * @return string
     */
    protected function getDefaultLevelName()
    {
        return ucwords(Str::snake(class_basename($this), ' '));
    }

    /**
     * Get the default icon if not provided
     *
     * @return string
     */
    protected function getDefaultIcon()
    {
        return sprintf(
            '%s/%s%s',
            rtrim(config('gamify.badge_icon_folder', 'images/badges'), '/'),
            Str::kebab(class_basename($this)),
            config('gamify.badge_icon_extension', '.svg')
        );
    }

    /**
     * Store or update badge
     *
     * @return mixed
     */
    protected function storeLevel()
    {
        $level = app(Level::class)
            ->firstOrNew(['name' => $this->getName()])
            ->forceFill([
                'badge_id' => $this->getBadge(),
                'description' => $this->getDescription(),
                'icon' => $this->getIcon()
            ]);

        $level->save();

        return $level;
    }
}
