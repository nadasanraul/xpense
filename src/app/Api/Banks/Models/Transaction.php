<?php

namespace App\Api\Banks\Models;

use Carbon\Carbon;
use App\Api\Core\Models\BaseModel;

/**
 * Class Transaction
 * @property string $uuid
 * @property int $account_id
 * @property string $title
 * @property int $amount
 * @property string $type
 * @property Carbon $completed_at
 * @property Account $account
 * @package App\Api\Banks\Models
 */
class Transaction extends BaseModel
{
    /**
     * The attributes that can be mass assignable
     *
     * @var string[]
     */
    protected $fillable = ['uuid', 'account_id', 'title', 'amount', 'type', 'completed_at'];

    /**
     * The attributes that the model can be sorted by
     *
     * @var string[]
     */
    protected $sortingFields = ['title', 'amount', 'completed_at'];

    /**
     * Defines the relation with Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
