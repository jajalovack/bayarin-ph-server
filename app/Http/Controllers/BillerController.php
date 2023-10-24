<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biller;

class BillerController extends Controller
{
    public function billers()
    {
        $biller=Biller::all();
        $response=[];
        for ($i=0;$i<count($biller);$i++)
        {
            array_push($response,[
                'id'=>$biller[$i]->id,
                'biller'=>$biller[$i]->biller
            ]);
        }
        return response($response,200);
    }
}
