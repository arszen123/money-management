<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/24/18
 * Time: 7:43 PM
 */

namespace App\Repository;


use App\Model\Category;
use App\Model\User;
use Carbon\Carbon;

class TransactionRepository
{
    public static function storeTransaction(User $user, $transactionData)
    {
        $transactionData['user_id'] = $user->id;
        $transactionData = self::prepareTransactionData($transactionData);
        $wallet = WalletRepository::getUserWallet(
            $user,
            $transactionData['wallet_id']
        );
        if (!$wallet) {
            throw new \Exception('Entity not found!1');
        }
        $category = CategoryRepository::getUserCategory(
            $user,
            $transactionData['category']
        );
        if (!$category) {
            throw new \Exception('Entity not found!');
        }

        $success = \DB::insert(
            'insert into `transaction` (user_id, wallet_id, category_id, amount, comment, tag, updated_at, created_at) values (:user_id, :wallet_id, :category, :amount, :comment, :tag, :updated_at, :created_at)',
            $transactionData
        );
        if ($success) {
            $amount = $transactionData['amount'];
            if ((int)$category->type === Category::TYPE_EXPENSE) {
                $amount *= -1;
                BudgetRepository::updateBudgetsBalanceByCategoryId(
                    $category->id,
                    [
                        'amount' => $amount,
                        'date' => $transactionData['created_at']
                    ]
                );
            }
            WalletRepository::updateUserWalletBalance(
                $user,
                $wallet->id,
                $wallet->balance + $amount
            );
        }
    }

    public static function updateTransaction(
        User $user,
        $transactionId,
        $transactionData
    ) {
        $transactionData['user_id'] = $user->id;
        $transactionData = self::prepareTransactionData($transactionData);
        $transactionData['updated_at'] = Carbon::now()->format('Y-m-d');
        $transactionData['transaction_id'] = $transactionId;

        $wallet = WalletRepository::getUserWallet(
            $user,
            $transactionData['wallet_id']
        );
        if (!$wallet) {
            throw new \Exception('Entity not found!');
        }
        $category = CategoryRepository::getUserCategory(
            $user,
            $transactionData['category']
        );
        if (!$category) {
            throw new \Exception('Entity not found!');
        }

        $amount = \DB::select('SELECT amount, category_id from `transaction` WHERE id = ?',
                [$transactionId])[0] ?? null;
        $success = \DB::insert(
            'UPDATE `transaction` SET category_id = :category, amount = :amount, comment = :comment, tag = :tag, updated_at = :updated_at, created_at = :created_at WHERE wallet_id = :wallet_id AND id = :transaction_id AND user_id = :user_id',
            $transactionData
        );
        if ($success && $amount) {
            $newAmount = $transactionData['amount'] - $amount->amount;
            if ((int)$amount->category_id === (int)$transactionData['category']) {
                BudgetRepository::updateBudgetsBalanceByCategoryId(
                    $amount->category_id,
                    [
                        'amount' => -$newAmount,
                        'date' => $transactionData['created_at']
                    ]
                );
            } else {
                BudgetRepository::updateBudgetsBalanceByCategoryId(
                    $amount->category_id,
                    [
                        'amount' => $amount->amount,
                        'date' => $transactionData['created_at']
                    ]
                );
                BudgetRepository::updateBudgetsBalanceByCategoryId(
                    $transactionData['category'],
                    [
                        'amount' => -$transactionData['amount'],
                        'date' => $transactionData['created_at']
                    ]
                );
            }
            WalletRepository::updateUserWalletBalance(
                $user,
                $wallet->id,
                $wallet->balance + $newAmount
            );
        }
    }

    public static function deleteTransaction(User $user, $transactionId)
    {
        $transaction = self::getTransactionAmount($transactionId);
        WalletRepository::updateUserWalletWithBalance($user, $transaction['wallet_id'], $transaction['amount']);
        return \DB::delete('DELETE FROM `transaction` WHERE user_id = :user_id AND id = :transaction_id',
            [
                'user_id' => $user->id,
                'transaction_id' => $transactionId
            ]);
    }

    private static function prepareTransactionData($transactionData)
    {
        $transactionData['amount'] = abs($transactionData['amount']);
        $transactionData['tag'] = $transactionData['tag'] ?? null;
        $transactionData['comment'] = $transactionData['comment'] ?? null;
        $transactionData['created_at'] = $transactionData['date'] ?? Carbon::now();
        $transactionData['updated_at'] = $transactionData['date'] ?? Carbon::now();
        unset($transactionData['type'], $transactionData['date']);
        return $transactionData;
    }

    public static function getTransactionAmount($transactionId)
    {
        $balance = \DB::select('SELECT wallet_id, CASE WHEN c.type = 1 THEN amount*-1 ELSE amount END as amount FROM `transaction` t LEFT JOIN category c ON t.category_id = c.id WHERE t.id = :transaction_id',
            [
                'transaction_id' => $transactionId
            ]);
        return isset($balance[0]) ? (array)$balance[0] : [];
    }

    public static function getTransactions(User $user, $toDisplay = null)
    {
        return \DB::select(
            'select * from `transaction` where user_id= :user_id ORDER BY created_at DESC',
            [$user->id]
        );
    }

    public static function getTransactionToDisplay(User $user, $data)
    {
        $sql = 'select c.name as categoryName, c.type as type, t.* from `transaction` t LEFT JOIN category c ON t.category_id = c.id where t.user_id= :user_id';
        self::addCreatedAt($sql, 't', $data);
        $sql .= ' ORDER BY t.created_at DESC';
        return \DB::select($sql, array_merge(['user_id' => $user->id], $data));
    }

    public static function getTransactionsToDisplayByBudgetId(
        int $budgetId,
        $data
    ) {
        $sql = 'select c.name as categoryName, c.type as type, t.* from `transaction` t INNER JOIN budget_category bc ON bc.category_id = t.category_id LEFT JOIN category c ON t.category_id = c.id LEFT JOIN budget b ON b.id = bc.budget_id WHERE bc.budget_id = :id AND t.created_at BETWEEN b.from AND b.to';
        self::addCreatedAt($sql, 't', $data);
        $sql .= ' ORDER BY t.created_at DESC';
        return \DB::select($sql, array_merge(['id' => $budgetId], $data));
    }

    public static function getTransactionsToDisplayByCategoryId(
        $categoryId,
        $data
    ) {
        $sql = 'select c.name as categoryName, c.type as type, t.* from `transaction` t INNER JOIN category c ON t.category_id = c.id WHERE c.id = :id ';
        self::addCreatedAt($sql, 't', $data);
        $sql .= ' ORDER BY t.created_at DESC';
        return \DB::select($sql, array_merge(['id' => $categoryId], $data));
    }

    public static function getTransactionsToDisplayByTagId(
        User $user,
        $tag,
        $data
    ) {
        $sql = 'select c.name as categoryName, c.type as type, t.* from (SELECT * FROM `transaction` t WHERE t.tag = :tag1 OR t.tag LIKE :tag2 OR t.tag LIKE :tag3 OR t.tag LIKE :tag4) t INNER JOIN category c ON t.category_id = c.id WHERE t.user_id = :user_id';
        self::addCreatedAt($sql, 't', $data);
        $sql .= ' ORDER BY t.created_at DESC';
        return \DB::select($sql, array_merge([
            'user_id' => $user->id,
            'tag1' => $tag,
            'tag2' => '%,' . $tag,
            'tag3' => $tag . ',%',
            'tag4' => '%,' . $tag . ',%'
        ], $data));
    }

    private static function addCreatedAt(&$sql, $table, $data)
    {
        if (isset($data['from'])) {
            $sql .= " AND ${table}.created_at >= " . ($data['prepare'] ? "'" . $data['from'] . "'" : ':from');
        }
        if (isset($data['to'])) {
            $sql .= " AND ${table}.created_at <= " . ($data['prepare'] ? "'" . $data['to'] . "'" : ':to');
        }
    }

    public static function getAmountByCategory(User $user, $data)
    {
        $sql = 'select t.category_id as id, SUM(t.amount) as amount from `transaction` t INNER JOIN category c ON t.category_id = c.id WHERE t.user_id = :user_id';
        self::addCreatedAt($sql, 't', $data);
        $sql .=  ' GROUP BY t.category_id';
        return json_decode(json_encode(\DB::select($sql, array_merge([
            'user_id' => $user->id
        ], $data))), true);
    }


    public static function getAmountByCategory1(User $user, $data, $type = Category::TYPE_EXPENSE)
    {
        $data['prepare'] = true;
        $sql1 = "select c.name, SUM(t.amount) as amount from `transaction` t INNER JOIN category c ON t.category_id = c.id WHERE t.user_id = {$user->id} AND c.type = ${type} ";
        self::addCreatedAt($sql1, 't', $data);
        $sql1 .= ' GROUP By c.name';
        $sql2 = "select SUM(t.amount) as amount from `transaction` t INNER JOIN category c ON t.category_id = c.id WHERE t.user_id = {$user->id} AND c.type = ${type} ";
        self::addCreatedAt($sql2, 't', $data);
        $sql = "SELECT CONCAT(c.name, ' (', c.amount, ')') as label, ROUND(c.amount*100/b.amount) as value from
                (${sql1}) as c,
                (${sql2}) as b
                GROUP BY c.name, c.amount, b.amount";
        return json_decode(json_encode(\DB::select($sql)), true);
    }

}