<?php


namespace App\Services;


use App\Models\Parking;
use App\Models\Prices;
use Illuminate\Support\Facades\Auth;

class PricesService
{

    public function CreatePrices(array $fields){

        $parking=Parking::where('id','=',$fields['parkings_id'])->first();
        $parking->Prices()->create([
            'firstHour'=>$fields['firstHour'],
            'nextHours'=>$fields['nextHours'],
            'overTimeHours'=>$fields['overTimeHours'],
        ]);
    }


    public function UpdatePrices(array $fields,Prices $prices){
        $prices->update([
            'firstHour'=> (!array_key_exists('firstHour',$fields)?$prices->firstHour : $fields['firstHour']),
            'nextHours'=>(!array_key_exists('brand',$fields)?$prices->nextHours : $fields['nextHours']),
            'overTimeHours'=>(!array_key_exists('color',$fields)?$prices->overTimeHours : $fields['overTimeHours']),
        ]);
    }
}
