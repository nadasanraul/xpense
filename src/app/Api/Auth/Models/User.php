<?php

namespace App\Api\Auth\Models;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @property int $id
 * @property string $uuid
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string auth_driver
 * @property string $password
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Api\Auth\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email',
    ];
}
