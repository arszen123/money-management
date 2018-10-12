<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet';
    protected $fillable = ['user_id', 'name', 'balance'];
    public $timestamps = false;
}
