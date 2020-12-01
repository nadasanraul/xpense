<?php

namespace App\Api\Accounts\Models;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use App\Api\Core\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
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
class User extends BaseModel
{
    use Authenticatable, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email',
    ];

    /**
     * Use Username to find user for Passport
     *
     * @param $username
     *
     * @return User | null
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)
            ->orWhere('email', strtolower($username))
            ->first();
    }
}
