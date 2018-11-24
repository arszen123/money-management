<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ajax;
use App\Http\Requests\Budget as BudgetRequest;
use App\Repository\BudgetRepository;

class BudgetController extends Controller
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
        $budgets = BudgetRepository::getUserBudgets(\Auth::user());
        $response = ['success' => true, 'data' => $budgets];
        if (!\Request::ajax()) {
            $response = view('budget.index', ['budgets' => $budgets]);
        }
        return $response;
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
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetRequest $request)
    {
        $budget = BudgetRepository::storeUserBudget(\Auth::user(), $request->validated());
        return ['success' => true, 'data' => $budget];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = BudgetRepository::getUserBudgetsWithCategories(\Auth::user(), $id);
        return ['success' => true, 'budget' => $result];
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
    public function update(BudgetRequest $request, $id)
    {
        $budget = $request->validated();
        $success = BudgetRepository::updateUserBudget(\Auth::user(), array_merge($budget, ['id' => $id]));
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
        BudgetRepository::delete(\Auth::user(), $id);
    }
}
