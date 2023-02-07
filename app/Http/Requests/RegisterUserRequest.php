<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>'required|string|email|unique:App\Models\User,email',
            'name'=>'string|required|max:50',
            'surname'=>'string|required|max:50',
            'phone'=>'string|required|max:9',
            'password'=>"string|required|min:6|confirmed"
        ];
    }
}
