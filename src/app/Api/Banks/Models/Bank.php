<?php

namespace App\Api\Banks\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 * @property integer $id
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Api\Banks\Models
 */
class Bank extends Model
{
    /**
     * The attributes hidden for serialization
     *
     * @var string[]
     */
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
