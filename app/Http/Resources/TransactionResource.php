<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $bill=$this->bill;
        $payor=$request->user();
        $billStatus=$bill->billstatus;
        return [
            'id'=>$this->id,
            'bill'=>[
                'id'=>$bill->id,
                'refnum'=>$bill->refnum,
                'biller'=>$bill->biller->biller,
                'category'=>$bill->category->category,
                'billed_to'=>$bill->billed_to,
                'description'=>$bill->description,
                'amount'=>$bill->amount,
                'status'=>$bill->billstatus_id==3?'Paid by '.$payor->first_name.' '.$payor->last_name:$billStatus->status
            ],
            'payment_method'=>$this->paymentmethod->payment_method,
            'status'=>$this->transactionstatus->status
        ];
    }
}
