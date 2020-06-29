<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class auth extends Controller
{

    use apiTrait;

    public function register(Request $request){


            $validator =   Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', ],
            ]);

        if($validator->fails()){

            return $this->apiResponce(null , $validator->errors(), 400);

        }else{
                    $data = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'api_token' => Str::random(60)
                    ]);


                    return $this->apiResponce($data , null, 200);
            }
}




public function login(Request $request){


    if(auth()->attempt(['email'=>$request->input('email'),'password'=>$request->input('password')])){

        $user = auth()->user();
        $user->api_token = Str::random(60);
        $user->save();

        return $this->apiResponce($user , null, 200);

    }
    return $this->apiResponce(null , 'incorrect email or password', 400);

}

public function logout(){


    if(auth()->user()){
        $user = auth()->user();
        $user->api_token = null;
        $user->save();

        return $this->apiResponce($user , null, 200);

    }
    return $this->apiResponce(null , 'unable to logout', 400);

}

}
