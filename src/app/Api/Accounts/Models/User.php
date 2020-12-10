<?php

namespace App\Api\Accounts\Models;

use App\Api\Banks\Models\Account;
use Laravel\Passport\HasApiTokens;
use App\Api\Core\Models\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Api\Banks\Models\ExpenseCategory;

/**
 * Class User
 * @property string $uuid
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string auth_driver
 * @property string $password
 * @property string $email
 * @property Collection $accounts
 * @property Collection $expenseCategories
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
     * Defines the relation with Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    /**
     * Defines the relation with ExpenseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class, 'user_id', 'id');
    }

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
