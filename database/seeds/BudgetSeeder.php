<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/21/18
 * Time: 9:23 PM
 */

class BudgetSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $this->insertBudgets();
        $this->insertBudgetCategoires();
    }

    private function insertBudgets()
    {
        DB::insert("
            INSERT INTO `budget` (`id`, `name`, `starting_balance`, `current_balance`, `from`, `to`, `user_id`) VALUES
            (1,	'Food',	'60000',	'30000',	'2018-09-21',	'2018-10-21',	1),
            (2,	'Transportation',	'15000',	'15000',	'2018-09-21',	'2018-10-21',	1),
            (3,	'Test',	'100000',	'100000',	'2018-09-21',	'2018-10-21',	1);
        ");
    }

    private function insertBudgetCategoires()
    {
        DB::insert('
            INSERT INTO `budget_categories` (`budget_id`, `category_id`) VALUES
            (2,	2),
            (1,	1);
        ');
    }

}