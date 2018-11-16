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
            INSERT INTO `budget` (`name`, `starting_balance`, `current_balance`, `from`, `to`, `user_id`) VALUES
            ('Food',	'30000',	'30000',	'2018-11-01',	'2018-11-30',	1),
            ('Transportation',	'10000',	'10000',	'2018-11-01',	'2018-11-30',	1),
            ('Entertainment',	'15000',	'15000',	'2018-11-01',	'2018-11-30',	1),
            ('Food',	'30000',	'30000',	'2018-10-01',	'2018-10-31',	1),
            ('Transportation',	'10000',	'10000',	'2018-10-01',	'2018-10-31',	1),
            ('Entertainment',	'15000',	'15000',	'2018-10-01',	'2018-10-31',	1);
        ");
    }

    private function insertBudgetCategoires()
    {
        //
    }

}