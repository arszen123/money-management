<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/21/18
 * Time: 9:23 PM
 */

class CategorySeeder extends \Illuminate\Database\Seeder
{


    public function run()
    {
        DB::insert("
            INSERT INTO `category` (`id`, `user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
                (1,	1,	'Food',	2,	'food',	0),
                (2,	1,	'Transportation',	2,	'transportation',	0);
        ");
    }

}