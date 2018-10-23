<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/21/18
 * Time: 8:51 PM
 */

namespace App\Model;


class BudgetCategories extends \Eloquent
{
    protected $table = 'budget_categories';
    protected $fillable = [
        'budget_id', 'category_id'
    ];
    public $timestamps = false;
}