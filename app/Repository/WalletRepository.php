<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/23/18
 * Time: 8:37 PM
 */

namespace App\Repository;


use App\Model\User;
use App\Model\Wallet;

class WalletRepository
{

    public static function getUserWallets(User $user)
    {
        return \DB::select(
            'SELECT id, user_id, name, balance FROM wallet WHERE user_id = ?',
            [$user->id]
        );
    }

    public static function storeUserWallet(User $user, $walletData)
    {
        $walletData['user_id'] = $user->id;
        return \DB::insert(
            'insert into wallet (user_id, name, balance) values (:user_id, :name, :balance)',
            $walletData
        );
    }

    public static function updateUserWallet(User $user, $walletId, $walletData)
    {
        $walletData['user_id'] = $user->id;
        $walletData['id'] = $walletId;
        return \DB::update(
            'update wallet set `name`=:name, `balance`=:balance where id = :id AND user_id=:user_id',
            $walletData
        );
    }

    public static function getUserWallet(User $user, $walletId)
    {
        return \DB::select(
            'SELECT id, user_id, name, balance FROM wallet WHERE user_id = ? AND id = ?',
            [$user->id, $walletId]
        )[0] ?? null;
    }

    public static function deleteUserWallet(User $user, $walletId)
    {
        return \DB::delete(
            'DELETE FROM wallet WHERE user_id = ? AND id = ?',
            [$user->id, $walletId]
        );
    }

    public static function updateUserWalletBalance(User $user, $walletId, $walletBalance)
    {
        $walletData['user_id'] = $user->id;
        $walletData['id'] = $walletId;
        $walletData['balance'] = $walletBalance;
        return \DB::update(
            'update wallet set `balance`=:balance where id = :id AND user_id=:user_id',
            $walletData
        );
    }

}