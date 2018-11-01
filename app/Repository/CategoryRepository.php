<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/10/18
 * Time: 10:59 PM
 */

namespace App\Repository;


use App\Model\Category;
use App\Model\User;

class CategoryRepository
{

    public static function getActiveByUser(User $user)
    {
        return \DB::select(
            'SELECT id, `name`, `type`, icon
                FROM category
                WHERE user_id=:user_id AND is_deleted=:is_deleted',
            ['user_id' => $user->id, 'is_deleted' => 0]
        );
    }

    public static function getActiveByUserAndType(User $user, int $type)
    {
        return \DB::select(
            'SELECT id, `name`, `type`, icon
                FROM category
                WHERE user_id=:user_id AND is_deleted=:is_deleted AND `type`=:type',
            ['user_id' => $user->id, 'is_deleted' => 0, 'type' => $type]
        );
    }

    public static function getUserCategory(User $user, $categoryId)
    {
        $category = \DB::select(
            'SELECT id, user_id, `name`, `type`, icon, is_deleted
                FROM category
                WHERE id = :id AND user_id=:user_id',
            ['id' => $categoryId, 'user_id' => $user->id]
        );
        return $category[0] ?? null;
    }

    public static function storeUserCategory(User $user, $categoryData)
    {
        $categoryData['user_id'] = $user->id;
        return \DB::insert(
            'insert into category (`name`, `type`, `icon`, `user_id`)
                           values (:name, :type, :icon, :user_id)',
            $categoryData
        );
    }

    public static function updateUserCategory(User $user, $id, $categoryData)
    {
        $categoryData['user_id'] = $user->id;
        $categoryData['category_id'] = $id;
        return \DB::insert(
            'UPDATE category SET `name` = :name, `icon` = :icon
             WHERE `user_id` = :user_id AND `id`=:category_id',
            $categoryData
        );
    }

    public static function deleteUserCategory(User $user, $categoryId)
    {
        return \DB::update(
            'update category set is_deleted = 1 where id = ? AND user_id = ?',
            [$categoryId, $user->id]
        );
    }

}