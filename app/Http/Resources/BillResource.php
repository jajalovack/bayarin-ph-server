<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transaction = $this->transactions->last();

        $payor = User::where('id', $transaction->payor_id)->first();

        return [
            'id'=>$this->id,
            'refnum'=>$this->refnum,
            'biller'=>$this->biller->biller,
            'category'=>$this->category->category,
            'billed_to'=>$this->billed_to,
            'description'=>$this->description,
            'amount'=>$this->amount,
            'status'=>$this->billstatus_id==3?'Paid by '.$payor->first_name.' '.$payor->last_name:$this->billstatus->status
        ];
    }
}
