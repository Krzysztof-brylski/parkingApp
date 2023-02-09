<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PricesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->user()->id == Auth::id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstHour'=>'numeric|min:0',
            'nextHours'=>'numeric|min:0',
            'overTimeHours'=>'numeric|min:0',
        ];
    }
}
