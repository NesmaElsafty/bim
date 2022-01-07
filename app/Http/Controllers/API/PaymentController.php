<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;
use App\Models\Transaction;
use App\Models\Payment;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Payment::latest()->get();
        return response()->json([PaymentResource::collection($data), 'Payment fetched.']);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'transaction_id'=>'required',
            'amount'=>'required',
            'paid_on'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $payment = Payment::create([
            'transaction_id' => $request->transaction_id,
            'amount'=>$request->amount,
            'paid_on'=>$request->paid_on,
            'details'=>$request->details
         ]);
        return response()->json(['payment created successfully.', new PaymentResource($payment)]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(payment $payment)
    {
        $transaction = Transaction::find($payment->transaction_id);
        
        if (is_null($transaction)) {
            return response()->json('Data not found', 404); 
        }
            
        $data = array(
            'id' => $payment->id,
            'transaction_id' => $transaction->id,
            'amount' => $payment->amount,
            'paid_on' => $payment->paid_on,
            'details' => $payment->details,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
        );
        $dataa = json_encode($data);
        
        return $dataa;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment $payment)
    {
        //
        $payment->delete();

        return response()->json('payment deleted successfully');
    }
}
