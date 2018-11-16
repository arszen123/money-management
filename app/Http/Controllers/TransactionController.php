<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ajax;
use App\Model\Category;
use App\Repository\BudgetRepository;
use App\Repository\CategoryRepository;
use App\Repository\TransactionRepository;
use App\Repository\WalletRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Transaction as TransactionRequest;
use Illuminate\Support\Facades\Input;

class TransactionController extends Controller
{

    public function __construct()
    {
//        $this->middleware(Ajax::class)->except(['index', 'transactionsByBudgetId', 'transactionsByCategoryId', 'transactionsByTag', 'categoriesForChart']);
        $this->middleware('auth');
    }

    /** Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validator = \Validator::make(Input::toArray(), [
            'from' => 'date',
            'to' => 'date',
        ]);
        $data = $validator->validate();
        $transactions = TransactionRepository::getTransactionToDisplay(\Auth::user(), $data);
        $title = 'Transactions';
        $result = ['transactions' => $transactions, 'title' => $title];
        if (!\Request::ajax()) {
            $result = view('transaction.index',
                ['transactions' => $transactions, 'title' => $title]);
        }
        return $result;
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
     * @param  TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $success = true;
        $transaction = $request->validated();
        $transaction['wallet_id'] = $transaction['wallet_id'] ?? WalletRepository::getUserWallets(\Auth::user())[0]->id;
        try {
            TransactionRepository::storeTransaction(\Auth::user(), $transaction);
        } catch (\Exception $e) {
            $success = false;
        }
        return ['success' => $success];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        $success = true;
        $transaction = $request->validated();
        $transaction['wallet_id'] = $transaction['wallet_id'] ?? WalletRepository::getUserWallets(\Auth::user())[0]->id;
        try {
            TransactionRepository::updateTransaction(\Auth::user(), $id, $transaction);
        } catch (\Exception $e) {
            $success = false;
        }
        return ['success' => $success];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = TransactionRepository::deleteTransaction(\Auth::user(), $id);
        return ['success' => (bool) $success];
    }

    /* Other routes */

    public function transactionsByBudgetId($budgetId)
    {
        $validator = \Validator::make(Input::toArray(), [
            'from' => 'date',
            'to' => 'date',
        ]);
        $data = $validator->validate();
        $budget = BudgetRepository::getUserBudgets(\Auth::user(), $budgetId);
        if (!$budget) {
            abort(404);
        }
        $transactions = TransactionRepository::getTransactionsToDisplayByBudgetId($budgetId, $data);
        $title = 'Transactions in "' . $budget->name . '" budget';
        $result = ['transactions' => $transactions, 'title' => $title];
        if (!\Request::ajax()) {
            $result = view('transaction.index',
                ['transactions' => $transactions, 'title' => $title]);
        }
        return $result;
    }

    public function transactionsByCategoryId($categoryId)
    {
        $validator = \Validator::make(Input::toArray(), [
            'from' => 'date',
            'to' => 'date',
        ]);
        $data = $validator->validate();
        $category = CategoryRepository::getUserCategory(\Auth::user(), $categoryId);
        if (!$category) {
            abort(404);
        }
        $categories = TransactionRepository::getAmountByCategory(\Auth::user(),$data);
        $amount = array_filter($categories, function ($c) use ($categoryId) {
            return $c['id'] == $categoryId ? $c : null;
        });
        $amount = array_pop($amount)['amount'];
        $amountText = $category->type === Category::TYPE_EXPENSE ? 'Spent' : 'Income';
        $transactions = TransactionRepository::getTransactionsToDisplayByCategoryId($categoryId, $data);
        $title = "Transactions in \"{$category->name}\" category. ${amountText}: ${amount}";
        $result = ['transactions' => $transactions, 'title' => $title];
        if (!\Request::ajax()) {
            $result = view('transaction.index',
                ['transactions' => $transactions, 'title' => $title]);
        }
        return $result;
    }

    public function transactionsByTag($tag)
    {
        $validator = \Validator::make(Input::toArray(), [
            'from' => 'date',
            'to' => 'date',
        ]);
        $data = $validator->validate();
        $transactions = TransactionRepository::getTransactionsToDisplayByTagId(\Auth::user(), $tag, $data);
        $title = 'Transactions with "' . $tag . '" tag';
        $result = ['transactions' => $transactions, 'title' => $title];
        if (!\Request::ajax()) {
            $result = view('transaction.index',
                ['transactions' => $transactions, 'title' => $title]);
        }
        return $result;
    }

    public function categoriesForChart()
    {
        $validator = \Validator::make(Input::toArray(), [
            'from' => 'date',
            'to' => 'date',
        ]);
        $data = $validator->validate();
        if (empty($data)) {
            $data['from'] = Carbon::now()->startOfMonth()->format('Y-m-d');
            $data['to'] = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        $incomeCategories = TransactionRepository::getAmountByCategory1(\Auth::user(), $data, Category::TYPE_INCOME);
        $incomeCategories = array_map(function ($category) {
            $category['value'] = (int)$category['value'];
            return $category;
        }, $incomeCategories);
        $expenseCategories = TransactionRepository::getAmountByCategory1(\Auth::user(), $data);
        $expenseCategories = array_map(function ($category) {
            $category['value'] = (int)$category['value'];
            return $category;
        }, $expenseCategories);
        return view('transaction.chart', ['incomeCategories' => $incomeCategories, 'expenseCategories' => $expenseCategories, 'data' => $data]);
    }
}
