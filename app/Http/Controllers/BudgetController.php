<?php

namespace App\Http\Controllers;

use App\Http\Requests\Budget as BudgetRequest;
use App\Model\Budget;
use App\Model\BudgetCategories;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = Budget::where('user_id', \Auth::id())->get([
            'id', 'name', 'from', 'to', 'current_balance', 'starting_balance'
        ]);
        return ['success' => true, 'data' => $budgets->toArray()];
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
        $budget = $request->validated();
        $budget['user_id'] = \Auth::id();
        $budget['current_balance'] = $budget['starting_balance'];
        $budgetCategories = $budget['categories'];
        $createdBudget = Budget::create($budget);

        foreach ($budgetCategories as $budgetCategoryId) {
            BudgetCategories::create([
                'budget_id' => $createdBudget->id,
                'category_id' => $budgetCategoryId,
            ]);
        }
        return ['success' => true, 'data' => $createdBudget];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $budget = Budget::where('user_id', \Auth::id())->where('id', $id)->get([
            'id', 'name', 'from', 'to', 'starting_balance'
        ]);
        $result = $budget->get(0)->toArray();
        $result['categories'] = BudgetCategories::where('budget_id', $result['id'])->pluck('category_id')->toArray();
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
        $budgetCategories = $budget['categories'];
        unset($budget['categories']);
        $success = Budget::where('user_id', \Auth::id())->where('id', $id)->update($budget);
        BudgetCategories::where('budget_id', $id)->delete();
        if (is_array($budgetCategories)) {
            foreach ($budgetCategories as $budgetCategoryId) {
                BudgetCategories::create([
                    'budget_id' => $id,
                    'category_id' => $budgetCategoryId,
                ]);
            }
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
        //
    }
}
