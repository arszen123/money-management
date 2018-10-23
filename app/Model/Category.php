<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Category
 *
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['user_id', 'name', 'type', 'icon', 'is_deleted'];
    public $timestamps = false;
}
