<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ajax;
use App\Model\Category;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Category as CategoryRequest;
use App\Http\Requests\CategoryUpdate as CategoryUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(Ajax::class)->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $categories = [];
        if ($type) {
            $categories = CategoryRepository::getActiveByUserAndType(Auth::user(), $type);
        } else {
            $categories = CategoryRepository::getActiveByUser(Auth::user());
        }
        $result = view('category.index',['categories' => $categories]);
        if ($request->ajax()) {
            $result = ['categories' => $categories];
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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(CategoryRequest $request)
    {
        $categoryData = $request->validated();
        $success = CategoryRepository::storeUserCategory(Auth::user(), $categoryData);

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
        $category = CategoryRepository::getUserCategory(Auth::user(), $id);
        return (array)$category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryRequest $request, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        CategoryRepository::updateUserCategory(Auth::user(), $id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CategoryRepository::deleteUserCategory(Auth::user(), $id);
    }
}
