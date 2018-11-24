<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/23/18
 * Time: 8:37 PM
 */

namespace App\Repository;


use App\Model\Budget;
use App\Model\BudgetCategories;
use App\Model\User;
use Illuminate\Support\Facades\DB;

class BudgetRepository
{

    public static function storeUserBudget(User $user, $budgetData)
    {
        $budgetData['user_id'] = $user->id;
        $budgetData['current_balance'] = $budgetData['starting_balance'];
        $budgetCategories = $budgetData['categories'];
        unset($budgetData['categories']);
        $amount = self::getTransactionsAmount($user, ['categories' => $budgetCategories, 'from' => $budgetData['from'], 'to' => $budgetData['to']]);
        $budgetData['current_balance'] -= $amount;
        DB::insert(
            'insert into budget (`name`, starting_balance, current_balance, `from`, `to`, user_id) values (:name, :starting_balance, :current_balance, :from, :to, :user_id)',
            $budgetData
        );
        $budgetId = DB::getPdo()->lastInsertId();
        self::saveBudgetCategories($budgetId, $budgetCategories);
        return Budget::fromQuery(
            'Select * from budget where id = ?',
            [$budgetId]
        );
    }

    public static function updateUserBudget(User $user, $budgetData)
    {
        $success = true;
        $budgetData['user_id'] = $user->id;
        $budgetCategories = $budgetData['categories'];
        $amount = self::getTransactionsAmount($user, ['categories' => $budgetCategories, 'from' => $budgetData['from'], 'to' => $budgetData['to']]);
        unset($budgetData['categories']);
        DB::update(
            'update budget set `name`= :name, starting_balance=:starting_balance, `from`=:from, `to`=:to where user_id = :user_id and id = :id',
            $budgetData
        );
        DB::update(
            'update budget set current_balance = starting_balance - :balance where user_id = :user_id and id = :id',
            ['balance' =>  $amount, 'user_id' => $user->id, 'id' => $budgetData['id']]
        );
        DB::delete(
            'DELETE FROM budget_category WHERE budget_id = ?',
            [$budgetData['id']]
        );
        self::saveBudgetCategories($budgetData['id'], $budgetCategories);
        return $success;
    }

    private static function saveBudgetCategories($budgetId, $budgetCategories)
    {
        if (is_array($budgetCategories)) {
            foreach ($budgetCategories as $categoryId) {
                DB::insert(
                    'insert into budget_category (budget_id, category_id) values (?, ?)',
                    [$budgetId, $categoryId]
                );
            }
        }
    }

    public static function getUserBudgets(User $user, $id = null)
    {
        $bindings['user_id'] = $user->id;
        $query = 'SELECT budget.id, `name`, `from`, `to`, CASE WHEN bcb.amount IS NOT NULL THEN (starting_balance - bcb.amount) ELSE starting_balance END as current_balance , starting_balance FROM budget LEFT JOIN (SELECT b.id, SUM(t.amount) as amount from `transaction` t INNER JOIN budget_category bc ON bc.category_id = t.category_id LEFT JOIN category c ON t.category_id = c.id LEFT JOIN budget b ON b.id = bc.budget_id WHERE t.created_at BETWEEN b.from AND b.to GROUP BY b.id) bcb ON bcb.id = budget.id WHERE user_id = :user_id';
        if ($id !== null) {
            $bindings['budget_id'] = $id;
            $query .= ' AND budget.id = :budget_id';
        }

        $budgets =  DB::select(
            $query,
            $bindings
        );

        return $id !== null ? $budgets[0]??null : $budgets;
    }

    public static function getUserBudgetsWithCategories(User $user, $budgetId)
    {
        $budget = self::getUserBudgets($user, $budgetId);
        if (!$budget) {
            throw new \Exception('Entity not found');
        }
        $budget = (array)$budget;
        $budget['categories'] = self::getBudgetCategories($budgetId);
        return $budget;
    }

    public static function getBudgetCategories($budgetId)
    {
        $categories = DB::select('SELECT category_id FROM budget_category WHERE budget_id = ?', [$budgetId]);
        $res = [];
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $res[] = $category->category_id;
            }
        }
        return $res;
    }

    public static function getBudgetIdsByCategoryId($categoryId)
    {
        $budgets = DB::select(
            'SELECT budget.id FROM budget_category LEFT JOIN budget ON budget_category.budget_id = budget.id WHERE budget_category.category_id = ?',
            [$categoryId]
        );
        $res = [];
        if (!empty($budgets)) {
            foreach ($budgets as $budget) {
                $res[] = $budget->id;
            }
        }
        return $res;
    }

    public static function updateBudgetsBalanceByCategoryId($categoryId, $transactionData)
    {
        $data['transaction_amount'] = $transactionData['amount'];
        $data['transaction_date'] = $transactionData['date'];
        $data['category_id'] = $categoryId;
        DB::update(
            'UPDATE budget RIGHT JOIN budget_category ON budget_category.budget_id = budget.id SET current_balance = current_balance + :transaction_amount WHERE budget_category.category_id = :category_id AND :transaction_date BETWEEN `from` AND `to`',
            $data
        );
    }

    public static function delete(User $user, int $id)
    {
        return \DB::delete('DELETE FROM budget WHERE user_id = :user_id AND id = :id', ['user_id' => $user->id, 'id' => $id]);
    }

    /**
     * Return category ids which are not in the selected budget
     *
     * @param $budgetId
     * @param $categories
     * @return array
     */
    private static function diffBudgetCategories($budgetId, $categories)
    {
        $diff = DB::select(
            'SELECT category_id as id FROM budget_category WHERE category_id NOT IN (:category_ids) AND budget_id = :budgetId',
            ['budgetId' => $budgetId, 'category_ids' => implode(',', $categories)]
        );
        $res = [];
        foreach ($diff as $category) {
            $res[] = $category->id;
        }
        return $res;
    }

    private static function updateUserBudgetBalance(User $user, $amount)
    {

    }

    private static function getTransactionsAmount(User $user, $data)
    {
        $userID = $user->id;
        $categories = implode(', ', $data['categories']);
        if (empty($data['categories'])) {
            return 0;
        }
        $sql = "SELECT sum(amount) as amount FROM `transaction` WHERE category_id IN (${categories}) AND created_at BETWEEN '${data['from']}' AND '${data['to']}' AND user_id=${userID}";
        $amount = DB::select($sql);
        return $amount[0]->amount;
    }

}