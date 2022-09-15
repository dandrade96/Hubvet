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
        $sector = Sector::all();

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
        $validator = Validator::make($field, [
            'name' => ['required', 'min:3'],
            'user_id' => ['required'],
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
        $sector = Sector::find($id);
        
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

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $sector->name = $field['name'];
        $sector->save();

        return $this->sendResponse(new SectorResource($sector), 'Sector updated successfully.');
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        $sector->delete();

        return $this->sendResponse([], 'Sector deleted successfully.');
    }
}
