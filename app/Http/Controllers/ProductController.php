<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;

use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {   
        return $success['products'] = Product::All()->whereNotIn('user_id', $user_id)->map(function($product){            
                
            $product->image_url = config('app.host_base_url').Storage::url($product->image_url);   
            if ($product->image_url == "/storage/")
                $product->image_url = null;  
            return $product;
        })->flatten();
        return $this->sendResponse($success , 'Products Retrieved Successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all() , [  
            'user_id'                   => 'required' ,        
            'name'                      => 'required' ,     
            'brief'                     => '',
            'description'               => '',
            'price'                     => '',
            'image'                     => '',
        ]);

        if($validator->fails())
            return $this->sendError('Error Validation' , $validator->errors());        

        if(!User::where('id' , $request->user_id)->exists())
            return $this->sendError('User is not exists.',array(1 =>'User is not exists.'));
        

        if (!$request->hasFile('image'))
            return $this->sendError('File Not Uploaded' , array(1 =>'File Not Uploaded.'));  ;
                
        $image_paths = storeImage( $request->file('image') ,'productImages');                           

        $product = Product::create([
            'user_id'               => $request->user_id,
            'name'                  => $request->name,                        
            'brief'                 => $request->brief,                        
            'description'           => $request->description,                        
            'price'                 => $request->price,    
            'image_url'             => $image_paths['org_path'],    
        ]);
        return $product;        
        $success['product']         = $product;        

        return $this->sendResponse($success, "Product Has Been Created Successfully!");


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
         $product = Product::find($product_id);
         $product->image_url = config('app.host_base_url').Storage::url($product->image_url);   
         if ($product->image_url == "/storage/")
             $product->image_url = null;          

         $images = $product->images->sortByDesc('id')->map(function($image){
            $image->image_url = config('app.host_base_url').Storage::url($image->image_url);   
            if ($image->image_url == "/storage/")
                $image->image_url = null;  
            return $image;
         })->flatten();
         $product->setRelation('images',$images);
         return $product;
    }
    public function showByUser($userId){
        $user = User::find($userId);


        return $product = $user->products->map(function($product){            
                
            $product->image_url = config('app.host_base_url').Storage::url($product->image_url);   
            if ($product->image_url == "/storage/")
                $product->image_url = null;  
            return $product;
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
