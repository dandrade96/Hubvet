<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Market;
use App\Models\Sector;

class SupermarketController extends BaseController
{
    public function index(){
        $user = Auth::user();
        $supermarket = Market::where('user_id', $user->id)->get();
        $market = [];
        foreach($supermarket as $spm){
            $data = Market::findOrFail($spm->id);
            $data['sector'] = $spm->sector;
            array_push($market, $data);
                foreach($data['sector'] as $sct){
                    $data = Sector::findOrFail($sct->id);
                    $data['products'] = $sct->product;
                }
        }
        if(!empty($market)){
            return  $this->sendResponse($market, 'Markets retrieved successfully.');
        }
        return  $this->sendResponse($market, 'Called is empty.');
    }

}
