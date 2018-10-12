<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ajax;
use App\Model\Category;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Category as CategoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(Ajax::class, ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = CategoryRepository::getActiveByUser(Auth::id());
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
        $categoryData['user_id'] = Auth::id();
        $category = \App\Model\Category::create($categoryData);

        return ['success' => (boolean)$category];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = CategoryRepository::getByIdAndUserId($id, Auth::id());
        return $category[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryRequest $request, $id)
    {
//        $categoryData = $request->validated();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        /** @var Category $category */
        $category = CategoryRepository::getByIdAndUserId($id, Auth::id())[0];
        $category->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = CategoryRepository::getByIdAndUserId($id, Auth::id())[0];
        $category->update(['is_deleted' => true]);
    }
}
