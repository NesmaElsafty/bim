<?php

namespace App\Http\Controllers\API;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Transaction;
use App\Models\Category;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Transaction::latest()->get();
        return response()->json([TransactionResource::collection($data), 'Transactions fetched.']);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'category_id'=>'required',
            // 'user_id'=>'required',
            'amount'=>'required',
            'due_date'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $current_date = date("d-m-Y");
        $due_date = $request->due_date;

        // if ($current_date > $due_date){
        //     $status = "";
        // }elseif($current_date > $due_date) {
        //     $status = "";
        // }else{
        //     $status = "";
        // }
        $transaction = Transaction::create([
            'name' => $request->name,
            'category_id'=>$request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'user_id'=>$request->user_id,
            'amount'=>$request->amount,
            'due_date'=>$request->due_date,
            'status' => "Pending"
         ]);
        
        return response()->json(['Transaction created successfully.', new TransactionResource($transaction)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $transaction = Transaction::find($id);
        if (is_null($Transaction)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new TransactionResource($transaction)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'category_id'=>'required',
            'user_id'=>'required',
            'amount'=>'required',
            'due_date'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $transaction->name = $request->name;
        $transaction->save();
        
        return response()->json(['Transaction updated successfully.', new TransactionResource($transaction)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $id->delete();

        return response()->json('Transaction deleted successfully');
    }
}
