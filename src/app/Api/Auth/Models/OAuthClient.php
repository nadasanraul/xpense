<?php

namespace App\Api\Auth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OAuthClient
 * @package App\Api\Auth\Models
 */
class OAuthClient extends Model
{
    /**
     * Incrementing property for the primary key
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'oauth_clients';
}
