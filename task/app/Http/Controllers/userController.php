<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Countries;
use Illuminate\Support\Facades\Auth;
use Validator;
   

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'country'=>'required',
            'password' => 'required',
            'type'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(["status"=>"Validation Error"]);       
        }
    
        $country=Countries::firstOrNew(["Name"=>$request->input('country')]);
        $country->save();
    
        $input = array();
        $input['email']=$request->input('email');
        $input['name']=$request->input('name');
        $input['password'] = bcrypt($request['password']);
        $input['countryId']=$country->id;
        $input['type']=$request->input('type');
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        return json_encode($success);
         }
         catch(\Exception $e)
         {
             return response()->json(["status"=>$e],400);
         }
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return json_encode($success);
        } 
        else{ 
            return response()->json(["status"=>"Unauthorised"],400);
        } 
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
