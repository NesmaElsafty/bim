<?php

namespace App\Http\Controllers\API;
use App\Models\SubCategory;
use App\Http\Resources\SubCategoryResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = SubCategory::latest()->get();
        return response()->json([SubCategoryResource::collection($data), 'SubCategories fetched.']);
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
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $subCategory = SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
         ]);
        
        return response()->json(['SubCategory created successfully.', new SubCategoryResource($subCategory)]);
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
        $subCategory = SubCategory::find($id);
        if (is_null($subCategory)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new SubCategoryResource($subCategory)]);
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
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $subCategory->name = $request->name;
        $subCategory->save();
        
        return response()->json(['SubCategory updated successfully.', new SubCategoryResource($subCategory)]);
    
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

        return response()->json('SubCategory deleted successfully');
    }
}
