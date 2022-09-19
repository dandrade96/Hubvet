<?php

namespace App\Http\Controllers;
use App\Http\Resources\MarketResource;
use Illuminate\Http\Request;
use App\Models\Market;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
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
        $market = Market::where('user_id', Auth::user()->id)->get();

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
        $field['user_id'] = Auth::user()->id;
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
        $market = Market::where('user_id', Auth::user()->id)->find($id);
        
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

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
        if($market->user_id != Auth::user()->id) return $this->sendError('Market not found.');

        $market->name = $field['name'];
        $market->address = $field['address'];
        $market->where('user_id', Auth::user()->id)->save();
       
        return $this->sendResponse(new MarketResource($market), 'Market updated successfully.');
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function destroy($id, Market $market)
    {
        if($market->user_id != Auth::user()->id) return $this->sendError('Market not found.');

        $market->where(['user_id' => Auth::user()->id, 'id' => $market->id])->delete();

        return $this->sendResponse([], 'Market deleted successfully.');
    }

}
