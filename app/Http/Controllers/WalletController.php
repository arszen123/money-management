<?php

namespace App\Http\Controllers;

use App\Model\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\Wallet as WalletRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var Collection $wallet */
        $wallet  = Wallet::where('user_id', \Auth::id())->get();
        $wallet = $wallet->get(0);
        if (!$wallet) {
            $walletData = ['name' => 'main Wallet', 'balance' => 0];
            $walletData['user_id'] = \Auth::id();
            $wallet = Wallet::create($walletData);
        }

        return view('wallet.index', ['wallet' => $wallet]);
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
        $wallet  = null;
        if (!Wallet::where('user_id', \Auth::id())->exists()) {
            $walletData = $request->validated();
            $walletData['user_id'] = \Auth::id();
            $wallet = Wallet::create($walletData);
        }
        return ['success' => (boolean)$wallet];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        return ['success' => Wallet::where('user_id', \Auth::id())->where('id', $id)->get()[0]];
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
        $wallet = Wallet::where('user_id', \Auth::id())->where('id', $id)->get()[0];
        $success = $wallet->update($request->validated());
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
        $wallet = Wallet::where('user_id', \Auth::id())->where('id', $id)->get()[0];
        return ['success' => $wallet->delete()];
    }
}
