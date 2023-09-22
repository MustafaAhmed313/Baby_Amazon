<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        return view('products.index', ['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        return view('products.create', ['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        if (Auth::id() != null) {
            $product =Product::create($request->all());
            $this->save_image($request->image, $product);
            return to_route('products.index');
        }
        return abort(401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return view('products.show' , $data=["product"=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        if (Auth::id() == $product->user_id) {
            return view('products.edit', ["product"=>$product]);
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $old_image = $product->image;
        $product->update($request->all());
        $this->save_image($request->image, $product);
        if($request->image){
            $this->delete_old_image($old_image);
        }
        return to_route('products.show',$product->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if (Auth::id() == $product->user_id) {
            $this->delete_old_image($product->image);
            $product->delete();
            return to_route("products.index");
        }
        return abort(401);
    }

//    function ask($id) {
//        return view("validate" , $data=["id"=>$id]);
//    }

    private  function  save_image($image, $product): void
    {
        if($image){
            $image_name = time().'.'.$image->extension();
            $image->move(public_path('images/products/'), $image_name);
            $product->image = $image_name;
            $product->save();
        }
    }
    private  function  delete_old_image($image_name): void
    {
        try{
            unlink('images/products/'.$image_name);
        }catch (Exception $e){
            echo $e;
        }
    }
}
