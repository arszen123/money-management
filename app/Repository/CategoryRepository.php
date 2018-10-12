<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/10/18
 * Time: 10:59 PM
 */

namespace App\Repository;


use App\Model\Category;

class CategoryRepository
{

    public static function getActiveByUser(int $id)
    {
        return Category::where('user_id', $id)->where('is_deleted', 0)->get(['id', 'name', 'type', 'icon']);
    }

    public static function getByIdAndUserId($categoryId, $userId)
    {
        return Category::where('user_id', $userId)->where('id', $categoryId)->get();
    }

}