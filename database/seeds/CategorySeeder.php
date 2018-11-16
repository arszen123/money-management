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
            INSERT INTO `category` (`user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
                (1,	'Food',	2,	'food',	0),
                (1,	'Transportation',	2,	'transportation',	0),
                (1,	'Entertainment',	2,	'entertainment',	0),
                (1,	'Education',	2,	'Education',	0),
                (1,	'Personal Care',	2,	'personal_care',	0),
                (1,	'Health & Fitness (was healthcare)',	2,	'health',	0),
                (1,	'Kids',	2,	'Education',	0),
                (1,	'Gifts & Donations',	2,	'gift',	0),
                (1,	'Bills & Utilities',	2,	'bill',	0),
                (1,	'Fees & Charges',	2,	'fee',	0),
                (1,	'Business Services',	2,	'business',	0),
                (1,	'Taxes',	2,	'taxes',	0);
        ");
        DB::insert("
            INSERT INTO `category` (`user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
                (1,	'Paycheck',	1,	'Paycheck',	0),
                (1,	'Investment',	1,	'Investment',	0),
                (1,	'Returned Purchase',	1,	'returned_purchase',	0),
                (1,	'Bonus',	1,	'bonus',	0),
                (1,	'Interest Income',	1,	'interest_income',	0),
                (1,	'Reimbursement',	1,	'reimbursment',	0),
                (1,	'Rental Income',	1,	'rent',	0);
        ");
    }

}