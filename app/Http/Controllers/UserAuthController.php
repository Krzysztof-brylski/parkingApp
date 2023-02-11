<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /**
     * Register new user
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request){
        $fields=$request->validated();
        $result = (new UserService())->RegisterUser($fields);

        return Response()->json($result,201);

    }

    /**
     * Login as user
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request){
        $fields=$request->validated();
        $user=User::where("email",'=',$fields['email'])->first();
        if(!$user or !Hash::check($fields['password'],$user->password)){
            return Response()->json("auth required",401);
        }

        $result = (new UserService())->LoginUser($user);
        return Response()->json($result,200);

    }

    /**
     * Logging out current logged user
     * @return JsonResponse
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return Response()->json("Logged out",200);
    }

}
