<?php


namespace App\Services;


use App\Models\Parking;
use Illuminate\Support\Facades\Auth;

class ParkingService
{
    public function CreateParking(array $fields, $user){
        $user->Parkings()->create([
            'address'=>$fields['address'],
            'city'=>$fields['city'],
            'localization'=>$fields['localization'],
            'parkingSpots'=>$fields['parkingSpots'],
            'availableParkingSpots'=>$fields['parkingSpots']
        ]);
    }

    public function UpdateParking(Parking $parking, array $fields){
        $parking->update([
            'address'=> (!array_key_exists('registryPlate',$fields)?$parking->address : $fields['address']),
            'city'=>(!array_key_exists('brand',$fields)?$parking->city : $fields['city']),
            'localization'=>(!array_key_exists('color',$fields)?$parking->localization : $fields['localization']),
            'parkingSpots'=>(!array_key_exists('color',$fields)?$parking->parkingSpots : $fields['parkingSpots']),
            'availableParkingSpots'=>(!array_key_exists('color',$fields)?$parking->parkingSpots : $fields['parkingSpots']),
        ]);
        $parking->save();
    }
}
