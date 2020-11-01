<?php

namespace App\Api\Banks\Models;

use App\Api\Accounts\Models\User;
use App\Api\Core\Models\BaseModel;

/**
 * Class Account
 * @property int $id
 * @property string $uuid
 * @property int $bank_id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int $balance
 * @property string $number
 * @property User $user
 * @property Bank $bank
 * @package App\Api\Banks\Models
 */
class Account extends BaseModel
{
    /**
     * The attributes that the model can be sorted by
     *
     * @var array
     */
    protected $sortingFields = ['name', 'description', 'balance'];

    /**
     * The attributes that can be used to search the model
     *
     * @var array
     */
    protected $searchFields = ['name', 'description', 'number'];

    /**
     * The attributes that can be mass assignable
     *
     * @var string[]
     */
    protected $fillable = ['uuid', 'name', 'description', 'bank_id', 'user_id', 'balance', 'number'];

    /**
     * Defines the relation with User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines the relation with Bank
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
