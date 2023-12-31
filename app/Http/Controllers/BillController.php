<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Biller;
use App\Models\Billstatus;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Resources\BillResource;

class BillController extends Controller
{
    // public function bills()
    // {
    //     $bill=Bill::all();
    //     $response=[];
    //     for ($i=0;$i<count($bill);$i++)
    //     {
    //         $status=Billstatus::where('id',$bill[$i]->billstatus_id)->first()->status;
    //         $transStatus=Transaction::where('bill_id',($i+1))->first();
            
    //         if($bill[$i]->status==3)
    //         {
    //             $payor=User::where('id',$transStatus->payor_id)->first();
    //             $payorName=$payor->first_name.' '.$payor->last_name;
    //             $status=$status.' '.$payorName;
    //         }
    //         array_push($response,[
    //             'id'=>$bill[$i]->id,
    //             'refnum'=>$bill[$i]->refnum,
    //             'biller'=>Biller::where('id',$bill[$i]->biller_id)->first()->biller,
    //             'category'=>Category::where('id',$bill[$i]->category_id)->first()->category,
    //             'billed_to'=>$bill[$i]->billed_to,
    //             'description'=>$bill[$i]->description,
    //             'amount'=>$bill[$i]->amount,
    //             'status'=>$status
    //         ]);
    //     }
    //     return response($response,200);
    // }

    public function bill($refnum)
    {
        $bill=Bill::where('refnum',$refnum)->get();

        if($bill)
        {
            return response(BillResource::collection($bill)->first(),200);
        }

        return response(['message'=>'Bill not found'],404);
    }
}
