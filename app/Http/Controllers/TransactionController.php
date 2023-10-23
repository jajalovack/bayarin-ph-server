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
use App\Http\Resources\TransactionResource;
use App\Http\Resources\BillResource;

class TransactionController extends Controller
{
    public function alltransactions()
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

    public function transactions(Request $request)
    {
        $transaction=Transaction::where('payor_id',$request->user()->id)->get();

        return response(TransactionResource::collection($transaction),200);
    }

    public function transaction($id)
    {
        $transaction=Transaction::where('id',$id)->first();
        if ($transaction)
        {
            $transactionResource = new TransactionResource($transaction);
            $transactionArray = $transactionResource->toArray(request());

            $payor = User::where('id', $transaction->payor_id)->first();
            $payorArray = [
                'payor' => [
                    'id' => $payor->id,
                    'first_name' => $payor->first_name,
                    'last_name' => $payor->last_name
                ],
            ];

            $response = collect($transactionArray)->merge($payorArray)->all();

            return response($response, 200);
        }

        return response(['message'=>'Transaction not found'],404);
    }

    public function pay(Request $request)
    {
        $fields=$request->validate([
            'bill_id'=>'required',
            'paymentmethod_id'=>'required',
            'transactionstatus_id'=>'required'
        ]);

        $bill=Bill::where('id',$request->bill_id)->first();

        if ($bill)
        {
            $billedTo=$bill->billed_to;
            $payor=$request->user();
            $payorName=$payor->first_name.' '.$payor->last_name;
            if ($billedTo==$payorName)
            {
                $status='Paid';
            }
            else
            {
                $status='Paid by '.$payorName;
            }

            if ($bill->billstatus_id==1)
            {
                $transaction=Transaction::create([
                    'bill_id'=>$fields['bill_id'],
                    'payor_id'=>$request->user()->id,
                    'paymentmethod_id'=>$fields['paymentmethod_id'],
                    'transactionstatus_id'=>$fields['transactionstatus_id']
                ]);
                if ($billedTo==$payorName)
                {
                    $bill->update(['billstatus_id'=>2]);
                }
                else
                {
                    $bill->update(['billstatus_id'=>3]);
                }
            }
            else
            {
                return response([
                    'message'=>'Bill is already paid',
                    'bill'=>[
                        'id'=>$bill->id,
                        'refnum'=>$bill->refnum,
                        'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                        'category'=>Category::where('id',$bill->category_id)->first()->category,
                        'billed_to'=>$bill->billed_to,
                        'description'=>$bill->description,
                        'amount'=>$bill->amount,
                        'status'=>$status,
                    ]
                ],409);
            }
            
            return response([
                'id'=>$transaction->id,
                'bill'=>[
                    'id'=>$bill->id,
                    'refnum'=>$bill->refnum,
                    'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                    'category'=>Category::where('id',$bill->category_id)->first()->category,
                    'billed_to'=>$bill->billed_to,
                    'description'=>$bill->description,
                    'amount'=>$bill->amount,
                    'status'=>$status,
                ],
                'payor'=>[
                    'id'=>$payor->id,
                    'first_name'=>$payor->first_name,
                    'last_name'=>$payor->last_name
                ],
                'status'=>Transactionstatus::where('id',$transaction->transactionstatus_id)->first()->status,
                'payment_method'=>Paymentmethod::where('id',$transaction->paymentmethod_id)->first()->payment_method
            ],201);
        }

        return response(['message'=>'Bill not found'],404);
    }

    public function refund(Request $request)
    {
        $fields=$request->validate([
            'refnum'=>'required'
        ]);

        $bill=Bill::where('refnum',$request->refnum)->first();

        if (!$bill)
        {
            return response(['message'=>'Bill with reference number '.$request->refnum.' does not exist.'],404);
        }

        $transaction=Transaction::where('bill_id',$bill->id)->where('payor_id',$request->user()->id)->orderBy('id','desc')->first();

        if (!$transaction)
        {
            return response(['message'=>'You have not made any transactions with bill '.$request->refnum.'.'],404);
        }

        $billedTo=$bill->billed_to;
        $payor=User::where('id',$request->user()->id)->first();
        $payorName=$payor->first_name.' '.$payor->last_name;
        if ($billedTo==$payorName)
        {
            $status='Paid';
        }
        else
        {
            $status='Paid by '.$payorName;
        }

        if ($transaction->status==2)
        {
            return response([
                'message'=>'This transaction is not eligible for refund.',
                'transaction'=>[
                    'bill'=>[
                        'id'=>$bill->id,
                        'refnum'=>$bill->refnum,
                        'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                        'category'=>Category::where('id',$bill->category_id)->first()->category,
                        'billed_to'=>$bill->billed_to,
                        'description'=>$bill->description,
                        'amount'=>$bill->amount,
                        'status'=>'Unpaid',
                    ],
                    'payor'=>[
                        'id'=>$payor->id,
                        'first_name'=>$payor->first_name,
                        'last_name'=>$payor->last_name
                    ],
                    'status'=>Transactionstatus::where('id',$transaction->transactionstatus_id)->first()->status,
                    'payment_method'=>Paymentmethod::where('id',$transaction->paymentmethod_id)->first()->payment_method
                ]
            ],409);
        }
        else if ($transaction->status==3)
        {
            return response([
                'message'=>'This transaction is already reversed.',
                'transaction'=>[
                    'bill'=>[
                        'id'=>$bill->id,
                        'refnum'=>$bill->refnum,
                        'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                        'category'=>Category::where('id',$bill->category_id)->first()->category,
                        'billed_to'=>$bill->billed_to,
                        'description'=>$bill->description,
                        'amount'=>$bill->amount,
                        'status'=>'Unpaid',
                    ],
                    'payor'=>[
                        'id'=>$payor->id,
                        'first_name'=>$payor->first_name,
                        'last_name'=>$payor->last_name
                    ],
                    'status'=>Transactionstatus::where('id',$transaction->transactionstatus_id)->first()->status,
                    'payment_method'=>Paymentmethod::where('id',$transaction->paymentmethod_id)->first()->payment_method
                ]
            ],409);
        }
        else
        {
            $bill->update(['billstatus_id'=>1]);
            $transaction->update(['transactionstatus_id'=>3]);
            return response([
                'message'=>'Transaction reversed.',
                'transaction'=>[
                    'bill'=>[
                        'id'=>$bill->id,
                        'refnum'=>$bill->refnum,
                        'biller'=>Biller::where('id',$bill->biller_id)->first()->biller,
                        'category'=>Category::where('id',$bill->category_id)->first()->category,
                        'billed_to'=>$bill->billed_to,
                        'description'=>$bill->description,
                        'amount'=>$bill->amount,
                        'status'=>'Unpaid',
                    ],
                    'payor'=>[
                        'id'=>$payor->id,
                        'first_name'=>$payor->first_name,
                        'last_name'=>$payor->last_name
                    ],
                    'status'=>Transactionstatus::where('id',$transaction->transactionstatus_id)->first()->status,
                    'payment_method'=>Paymentmethod::where('id',$transaction->paymentmethod_id)->first()->payment_method
                ]
            ],200);
        }
    }
}
