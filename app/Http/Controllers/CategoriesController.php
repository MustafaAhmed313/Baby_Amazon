<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    function __construct(){
        $this->middleware('auth')->only('store', 'delete', 'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('categories.index', ['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('categories.create', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (Auth::id() != null) {
            $category =Category::create($request->all());
            return to_route('categories.index');
        }
        return abort(401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view('categories.show' , $data=["category"=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        if (Auth::id() == $category->user_id) {
            return view('categories.edit', ["category"=>$category]);
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        $category->update($request->all());
        return to_route('categories.show',$category->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        if (Auth::id() == $category->user_id ){
            $category->delete();
            return to_route("categories.index");
        }
        return  abort(401);
    }

//    function ask($id) {
//        return view("validate2" , $data=["id"=>$id]);
//    }
}
