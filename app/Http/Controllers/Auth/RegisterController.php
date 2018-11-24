<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use App\Repository\WalletRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        WalletRepository::storeUserWallet($user, ['name' => 'Main Wallet', 'balance' => 0]);

        \DB::insert("
            INSERT INTO `category` (`user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
                ({$user->id},	'Food',	2,	'food',	0),
                ({$user->id},	'Transportation',	2,	'transportation',	0),
                ({$user->id},	'Entertainment',	2,	'entertainment',	0),
                ({$user->id},	'Education',	2,	'Education',	0),
                ({$user->id},	'Personal Care',	2,	'personal_care',	0),
                ({$user->id},	'Health & Fitness (was healthcare)',	2,	'health',	0),
                ({$user->id},	'Kids',	2,	'Education',	0),
                ({$user->id},	'Gifts & Donations',	2,	'gift',	0),
                ({$user->id},	'Bills & Utilities',	2,	'bill',	0),
                ({$user->id},	'Fees & Charges',	2,	'fee',	0),
                ({$user->id},	'Business Services',	2,	'business',	0),
                ({$user->id},	'Taxes',	2,	'taxes',	0);
        ");
        \DB::insert("
            INSERT INTO `category` (`user_id`, `name`, `type`, `icon`, `is_deleted`) VALUES
                ({$user->id},	'Paycheck',	1,	'Paycheck',	0),
                ({$user->id},	'Investment',	1,	'Investment',	0),
                ({$user->id},	'Returned Purchase',	1,	'returned_purchase',	0),
                ({$user->id},	'Bonus',	1,	'bonus',	0),
                ({$user->id},	'Interest Income',	1,	'interest_income',	0),
                ({$user->id},	'Reimbursement',	1,	'reimbursment',	0),
                ({$user->id},	'Rental Income',	1,	'rent',	0);
        ");
        return $user;
    }
}
