<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductPicture;
use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;


class ProductPictureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product_id)
    {
        $product = Product::find($product_id);
       return $product_images =  $product->images->map(function($image){            
                
            $image->image_url = config('app.host_base_url').Storage::url($image->image_url);   
            if ($image->image_url == "/storage/")
                $image->image_url = null;  
            return $image;
        });
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
    public function store($product_id,Request $request)
    {        
        $data   = $request->all();

        $validator  = Validator::make($request->all() , [       
            'name'                  => '',            
        ]);

        if($validator->fails()){
            return $this->sendError('Error Validation' , $validator->errors());
        }

        if (!Product::where('id', '=', $product_id)->exists())  {
            return $this->sendError('Product Not Found.' , $validator->errors());
        }

        
        if(!$request->hasFile('image')){
            return "No File Uploaded";
        }
 

  
        $image_paths = storeImage($request->image ,'ProductImages');                        
        $product_image = ProductPicture::create([            
            'product_id'                => $product_id,
            'image_url'                => $image_paths['org_path'],  
        ]);
        

        $product = Product::find($product_id);
        $product->images->map(function($image){
            $image->image_url = config('app.host_base_url').Storage::url($image->image_url);   
            if ($image->image_url == "/storage/")
                $image->image_url = null;  
            return $image;
         });
         return $product;
        $success['product'] = $product;
        return $this->sendResponse($success , 'Product Images Uploaded Successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductPicture  $productPicture
     * @return \Illuminate\Http\Response
     */
    public function show(ProductPicture $productPicture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductPicture  $productPicture
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPicture $productPicture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductPicture  $productPicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPicture $productPicture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductPicture  $productPicture
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPicture $productPicture)
    {
        //
    }
}
