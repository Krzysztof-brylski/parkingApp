<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PricesCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (
            $this->user()->id == Auth::id() and
            Auth::user()->Parkings()->where(["id"=>$this->parkings_id])->exists()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'parkings_id'=>'required|exists:App\models\Parking,id',
            'firstHour'=>'required|numeric|min:0',
            'nextHours'=>'required|numeric|min:0',
            'overTimeHours'=>'required|numeric|min:0',
        ];
    }
}
