<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\SectorResource;
use App\Models\Sector;
use Validator;

class SectorController extends BaseController
{
    /**
     *  Display a list of the resource.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sector = Sector::where('user_id', Auth::user()->id)->get();

        return $this->sendResponse(SectorResource::collection($sector), 'Sector retrieved successfully.');
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
            'market_id' => ['required'],
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $sector = Sector::create($field);
        return $this->sendResponse(new SectorResource($sector), 'Sector created successfully.');
    }
    /**
     *  Display the specified resource.
     * 
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sector = Sector::where('user_id', Auth::user()->id)->find($id);
        
        if(is_null($sector)){
            return $this->sendError('sector not found.');
        }

        return $this->sendResponse(new SectorResource($sector), 'Sector retrieved successfully.');
    }
    /**
     *  Update the specified resource in storage.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sector $sector)
    {
        $field = $request->all();

        $validator = Validator::make($field,[
            'name' => ['required', 'min:3'],
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
        if($product->user_id != Auth::user()->id) return $this->sendError('Sector not found.');

        $sector->name = $field['name'];
        $sector->where('user_id', Auth::user()->id)->save();

        return $this->sendResponse(new SectorResource($sector), 'Sector updated successfully.');
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        if($sector->user_id != Auth::user()->id) return $this->sendError('Sector not found.');

        $sector->where(['user_id' => Auth::user()->id, 'id' => $sector->id])->delete();

        return $this->sendResponse([], 'Sector deleted successfully.');
    }
}
