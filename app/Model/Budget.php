<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Budget
 *
 * @mixin \Eloquent
 */
class Budget extends Model
{
    protected $table = 'budget';
    protected $fillable = [
        'name', 'from', 'to', 'starting_balance', 'current_balance', 'user_id'
    ];
    public $timestamps = false;
}
