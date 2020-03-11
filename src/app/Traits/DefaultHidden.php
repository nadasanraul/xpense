<?php

namespace App\Traits;

/**
 * Trait DefaultHidden
 * @package App\Traits
 */
trait DefaultHidden
{
    /**
     * Attributes that are hidden by default for all models
     *
     * @var string[]
     */
    protected $default_hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Getting the hidden attributes
     *
     * @return array
     */
    public function getHidden()
    {
        $hidden = array_diff($this->default_hidden, parent::getVisible());
        return array_merge($hidden, parent::getHidden());
    }
}
