<?php


namespace App\Services;


use App\Models\Car;
use App\Models\User;

class CarService
{
    public function CreateCar(array $fields, $user){
        $user->Cars()->create([
            'registryPlate'=>$fields['registryPlate'],
            'brand'=>$fields['brand'],
            'color'=>$fields['color']
        ]);
    }

    public function UpdateCar(array $fields, Car $car){
        $car->update([
            'registryPlate'=> (!array_key_exists('registryPlate',$fields)?$car->registryPlate : $fields['registryPlate']),
            'brand'=>(!array_key_exists('brand',$fields)?$car->brand : $fields['brand']),
            'color'=>(!array_key_exists('color',$fields)?$car->color : $fields['color']),
        ]);
        $car->save();
    }


}
