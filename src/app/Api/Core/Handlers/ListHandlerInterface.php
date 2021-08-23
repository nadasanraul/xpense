<?php

namespace App\Api\Core\Handlers;

/**
 * Interface ListHandlerInterface
 * @package App\Api\Core\Handlers
 */
interface ListHandlerInterface
{
    /**
     * Getting a resource list
     *
     * @return mixed
     */
    public function list();
}
