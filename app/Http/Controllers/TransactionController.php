<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Bill;
use App\Models\Paymentmethod;
use App\Models\Transactionstatus;
use App\Models\Biller;
use App\Models\Category;
use App\Models\Billstatus;

class TransactionController extends Controller
{
    public function transactions()
    {
        $transaction=Transaction::all();
        $response=[];
        for ($i=0;$i<count($transaction);$i++)
        {
            $bill=Bill::where('id',$transaction[$i]->bill_id)->first();
            $payor=User::where('id',$transaction[$i]->payor_id)->first();
            $method=Paymentmethod::where('id',$transaction[$i]->payment_method)->first();
            $status=Transactionstatus::where('id',$transaction[$i]->status)->first();
            array_push($response,[
                'id'=>$transaction[$i]->id,
                'bill'=>[
                    'id'=>$bill->id,
                    'refnum'=>$bill->refnum,
                    'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                    'category'=>Category::where('id',$bill->bill_category)->first()->category,
                    'billed_to'=>$bill->billed_to,
                    'description'=>$bill->description,
                    'amount'=>$bill->amount,
                    'status'=>Billstatus::where('id',$bill->status)->first()->status
                ],
                'payor'=>[
                    'id'=>$payor->id,
                    'first_name'=>$payor->first_name,
                    'last_name'=>$payor->last_name
                ],
                'payment_method'=>$method->payment_method,
                'status'=>$status->status
            ]);
        }

        return response($response,200);
    }

    public function transaction($id)
    {
        $transaction=Transaction::where('id',$id)->first();
        $bill=Bill::where('id',$transaction->bill_id)->first();
        $payor=User::where('id',$transaction->payor_id)->first();
        $method=Paymentmethod::where('id',$transaction->payment_method)->first();
        $status=Transactionstatus::where('id',$transaction->status)->first();
        return response([
            'id'=>$transaction->id,
            'bill'=>[
                'id'=>$bill->id,
                'refnum'=>$bill->refnum,
                'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                'category'=>Category::where('id',$bill->bill_category)->first()->category,
                'billed_to'=>$bill->billed_to,
                'description'=>$bill->description,
                'amount'=>$bill->amount,
                'status'=>Billstatus::where('id',$bill->status)->first()->status
            ],
            'payor'=>[
                'id'=>$payor->id,
                'first_name'=>$payor->first_name,
                'last_name'=>$payor->last_name
            ],
            'payment_method'=>$method->payment_method,
            'status'=>$status->status
        ],200);
    }
}
