<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationCreateRequest extends FormRequest
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
     * @return string
     */
    private function validateTime(){
        $time=Carbon::createFromFormat(
            'Y-m-d H:i',
            date('Y-m-d H:i')
        )->setTimezone($this->timeZone);
        return $time->toDateTimeString();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'car_id'=>'required|exists:App\models\Car,id',
            'parking_id'=>'required|exists:App\models\Parking,id',
            'timeZone'=>'required|timezone',
            'startTime'=>"date|date_format:Y-m-d H:i|required|after_or_equal:".$this->validateTime(),
            'paidTime'=>'numeric|required',
        ];
    }
}
