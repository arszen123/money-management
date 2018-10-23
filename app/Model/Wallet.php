<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Wallet
 *
 * @mixin \Eloquent
 */
class Wallet extends Model
{
    protected $table = 'wallet';
    protected $fillable = ['user_id', 'name', 'balance'];
    public $timestamps = false;
}
