<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paymentmethod;

class PaymentMethodController extends Controller
{
    public function paymentMethods()
    {
        $method=Paymentmethod::all();
        $response=[];
        for ($i=0;$i<count($method);$i++)
        {
            array_push($response,[
                'id'=>$method[$i]->id,
                'payment_method'=>$method[$i]->payment_method
            ]);
        }

        return response($response,200);
    }
}
