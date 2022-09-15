<?php

namespace App\Http\Controllers;
use App\Http\Resources\MarketResource;
use Illuminate\Http\Request;
use App\Models\Market;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class MarketController extends BaseController
{
    /**
     *  Display a listing of the resource.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $market = Market::all();

        return $this->sendResponse(MarketResource::collection($market), 'Market retrieved successfully.');
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
            'address' => ['required'],
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $market = Market::create($field);
        return $this->sendResponse(new MarketResource($market), 'Market created successfully.');
    }
    /**
     *  Display the specified resource.
     * 
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $market = Market::find($id);
        
        if(is_null($market)){
            return $this->sendError('Market not found.');
        }

        return $this->sendResponse(new MarketResource($market), 'Market retrieved successfully.');
    }
    /**
     *  Update the specified resource in storage.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        $field = $request->all();

        $validator = Validator::make($field,[
            'name' => ['required', 'min:3'],
            'address' =>['required'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $market->name = $field['name'];
        $market->address = $field['address'];
        $market->save();

        return $this->sendResponse(new MarketResource($market), 'Market updated successfully.');
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function destroy(Market $market)
    {
        $market->delete();

        return $this->sendResponse([], 'Market deleted successfully.');
    }

}
