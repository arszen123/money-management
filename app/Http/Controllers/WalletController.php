<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ajax;
use App\Model\Budget;
use App\Model\Wallet;
use App\Repository\BudgetRepository;
use App\Repository\WalletRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\Wallet as WalletRequest;

class WalletController extends Controller
{

    public function __construct()
    {
        $this->middleware(Ajax::class)->except('index');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = WalletRepository::getUserWallets(\Auth::user());
        $budgets = BudgetRepository::getUserBudgets(\Auth::user());
        return view('wallet.index', ['wallets' => $wallets, 'budgets' => $budgets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(WalletRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $wallet = WalletRepository::getUserWallet(\Auth::user(), $id);
        return ['success' => true, 'data' => $wallet];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(WalletRequest $request, $id)
    {
        $success = WalletRepository::updateUserWallet(\Auth::user(), $id, $request->validated());
        return ['success' => $success];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
//        $success = WalletRepository::deleteUserWallet(\Auth::user(), $id);
//        return ['success' => $success];
    }
}
