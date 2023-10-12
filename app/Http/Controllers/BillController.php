<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Biller;
use App\Models\Billstatus;
use App\Models\Category;

class BillController extends Controller
{
    public function bills()
    {
        $bill=Bill::all();
        $response=[];
        for ($i=0;$i<count($bill);$i++)
        {
            array_push($response,[
                'id'=>$bill[$i]->id,
                'refnum'=>$bill[$i]->refnum,
                'biller'=>Biller::where('id',$bill[$i]->biller_id)->first()->biller,
                'category'=>Category::where('id',$bill[$i]->bill_category)->first()->category,
                'billed_to'=>$bill[$i]->billed_to,
                'description'=>$bill[$i]->description,
                'amount'=>$bill[$i]->amount,
                'status'=>Billstatus::where('id',$bill[$i]->status)->first()->status
            ]);
        }
        return response($response,200);
    }

    public function bill($id)
    {
        $bill=Bill::where('id',$id)->first();
                
        return response([
            'id'=>$bill->id,
            'refnum'=>$bill->refnum,
            'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
            'category'=>Category::where('id',$bill->bill_category)->first()->category,
            'billed_to'=>$bill->billed_to,
            'description'=>$bill->description,
            'amount'=>$bill->amount,
            'status'=>Billstatus::where('id',$bill->status)->first()->status
        ],200);
    }
}
