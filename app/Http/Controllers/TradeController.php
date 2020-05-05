<?php

namespace App\Http\Controllers;

use App\Trade;
use App\TradeProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function offers($user_id)
    {
        return $user = User::find($user_id)->tradeOffers->map(function($offer){
            $offer->offeror         = User::find($offer->offeror_user_id);
            $offer->receiver        = User::find($offer->receiver_user_id);
            $offer->tradeProducts->map(function($tradeProduct) {
                $tradeProduct->offeredProduct;
                $tradeProduct->requestedProduct;
            });
            return $offer;
        });
    }

    public function offer($trade_id)
    {
        $offer = Trade::find($trade_id) ;        
        $offer->offeror             = User::find($offer->offeror_user_id);
        $offer->receiver            = User::find($offer->receiver_user_id);
        $offered_products       = array();
        $requested_products     = array();
        $offer->tradeProducts->map(function($tradeProduct) use (&$offered_products , &$requested_products ){ 
            $tradeProduct->offeredProduct->image_url =  config('app.host_base_url').Storage::url($tradeProduct->offeredProduct->image_url); 
            if ($tradeProduct->offeredProduct->image_url == "/storage/")
                $tradeProduct->offeredProduct->image_url = null;             
                
            $tradeProduct->requestedProduct->image_url =  config('app.host_base_url').Storage::url($tradeProduct->requestedProduct->image_url); 
            if ($tradeProduct->requestedProduct->image_url == "/storage/")
                $tradeProduct->requestedProduct->image_url = null;  

            $offered_products[]     = $tradeProduct->offeredProduct;
            $requested_products[]   = $tradeProduct->requestedProduct;
        });
        $offer->offered_products    =  array_unique($offered_products);
        $offer->requested_products  =  array_unique($requested_products);
        return $offer;
    }


    public function requests($user_id)
    {
        return $user = User::find($user_id)->tradeRequests->map(function($offer){
            $offer->offeror             = User::find($offer->offeror_user_id);
            $offer->receiver            = User::find($offer->receiver_user_id);
            $offer->tradeProducts->map(function($tradeProduct){
                $tradeProduct->offeredProduct;
                $tradeProduct->requestedProduct;
            });
            return $offer;
        });
    }


    public function request($trade_id)
    {
        $offer = Trade::find($trade_id) ;        
        $offer->offeror             = User::find($offer->offeror_user_id);
        $offer->receiver            = User::find($offer->receiver_user_id);
        $offered_products       = array();
        $requested_products     = array();
        $offer->tradeProducts->map(function($tradeProduct) use (&$offered_products , &$requested_products ){ 
            $tradeProduct->offeredProduct->image_url =  config('app.host_base_url').Storage::url($tradeProduct->offeredProduct->image_url); 
            if ($tradeProduct->offeredProduct->image_url == "/storage/")
                $tradeProduct->offeredProduct->image_url = null;             
                
            $tradeProduct->requestedProduct->image_url =  config('app.host_base_url').Storage::url($tradeProduct->requestedProduct->image_url); 
            if ($tradeProduct->requestedProduct->image_url == "/storage/")
                $tradeProduct->requestedProduct->image_url = null;  

            $offered_products[]     = $tradeProduct->offeredProduct;
            $requested_products[]   = $tradeProduct->requestedProduct;
        });
        $offer->offered_products    =  array_unique($offered_products);
        $offer->requested_products  =  array_unique($requested_products);
        return $offer;
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
                       
        $trade = Trade::Create([
            'offeror_user_id'       => $request->offeror_user_id,
            'receiver_user_id'      => $request->receiver_user_id,
            'longtitude'            => $request->longtitude,
            'latitude'              => $request->latitude
        ]);
        collect(json_decode($request->offeror_product))->map(function ($offerorProduct) use ($trade , $request) {
            TradeProduct::Create([
                "trade_id" => $trade->id,
                "offered_product_id" => $offerorProduct->id,
                "requested_product_id" => $request->receiver_product,
            ]);
        }); 
        // $TradeProducts=
        
        return $trade;
    }

    public function updateStatus(Request $request)
    {
        $trade = Trade::find($request->id);

        $trade->status = $request->status;
        $trade->save();
        return $trade;
    }

    public function updateLocation(Request $request)
    {
        $trade = Trade::find($request->id);

        $trade->longtitude            = $request->longtitude;
        $trade->latitude              = $request->latitude;
        $trade->save();
        return $trade;
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function edit(Trade $trade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trade $trade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade)
    {
        //
    }
}
