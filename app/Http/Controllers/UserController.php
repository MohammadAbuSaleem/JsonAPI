<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use carbon\Carbon;
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::All();
        $success['users'] = User::All();
        return $this->sendResponse($success , 'Users Retrieved Successfully.');        
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
            'name'                      => 'required' ,        
            'email'                     => 'required' ,     
            'password'                  => 'required',            
        ]);

        if($validator->fails()){
            return $this->sendError('Error Validation' , $validator->errors());
        }       

            
        if (User::where('email', '=', $request->email)->exists()){                
            return $this->sendError('User Already Exist.',array(1 =>'User Already Exist.'));
        }

        $user = User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'phone_number'          => $request->phone_number,
            'password'              => bcrypt($request->password),
        ]);        
        $success['user']                = $user;
        $success['token']               = $user->createToken('MyApp')->accessToken;

        return $this->sendResponse($success, "User Has Been Created Successfully!");
    }

    public function login (Request $request){
        // $validator      = Validator::make($request->all() , [
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);
        // if($validator->fails()){
        //     return $this->sendError('Error Validation' , $validator->errors());
        // }
        
        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials))            
            return $this->sendError('Unauthorized' , array(1 =>'Unauthorized'), 401);     
        
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');        
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();    
        
        $user->save();
        return $user;
        $success['user']                = $user;
        $success['token']               = $tokenResult->accessToken;        
        $success['expires_at']          = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();      

        return $this->sendResponse($success, "User Has Been Sign in Successfully!"); 

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
