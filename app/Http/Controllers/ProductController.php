<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Validator;

class ProductController extends BaseController
{
    /**
     *  Display a list of the resource.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return $this->sendResponse(ProductResource::collection($product), 'Product retrieved successfully.');
    }
    /**
     *  Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $field = $request->all();
        $validator = Validator::make($field, [
            'name' => ['required', 'min:3'],
            'description' => ['required'],
            'price' => ['required', 'numeric','min:0'],
            'quantify' => ['required', 'numeric','min:0'],
            'market_id' => ['required'],
            'sector_id' => ['required'],
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::create($field);
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }
    /**
     *  Display the specified resource.
     * 
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        
        if(is_null($product)){
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
    /**
     *  Update the specified resource in storage.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $field = $request->all();

        $validator = Validator::make($field,[
            'name' => ['required', 'min:3'],
            'description' => ['required'],
            'price' => ['required', 'numeric','min:0'],
            'quantify' => ['required', 'numeric','min:0'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $field['name'];
        $product->description = $field['description'];
        $product->price = $field['price'];
        $product->quantify = $field['quantify'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
