<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create user model and return it, with auth token
     * @param array $fields
     * @return array
     */
    public function RegisterUser(array $fields){

        $user=User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'surname'=>$fields['surname'],
            'phone'=>$fields['phone'],
            'password'=>Hash::make($fields['password']),
        ]);
        $token=$user->createToken(date("D M j G:i:s T Y"))->plainTextToken;
        return array(
            "user"=>$user,
            "token"=>$token,
        );
    }

    /**
     * Return user model and auth token for specified user
     * @param User $user
     * @return array
     */
    public function LoginUser(User $user){
        $token=$user->createToken(date("D M j G:i:s T Y"))->plainTextToken;
        return array(
            "user"=>$user,
            "token"=>$token,
        );
    }

}
