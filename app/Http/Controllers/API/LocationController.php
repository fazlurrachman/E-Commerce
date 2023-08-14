<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Province;
use App\Models\City;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return Province::all();
    }

    public function regencies(Request $request, $provinces_id)
    {
        return City::where('province_id', $provinces_id)->get();
    }

    public function cityID($city_id)
    {
        return City::find($city_id);
    }

    public function checkOngkir(Request $request)
    {
        //Fetch Rest API
        $response = Http::withHeaders([
            //api key rajaongkir
            'key'          => config('services.rajaongkir.key')
        ])->post('https://api.rajaongkir.com/starter/cost', [

            //send data
            'origin'      => 3, // ID kota Aceh Besar
            'destination' => $request->city_destination,
            'weight'      => 10,
            'courier'     => $request->courier
        ]);


        return response()->json([
            'success' => true,
            'message' => 'List Data Cost All Courir: ' . $request->courier,
            'data'    => $response['rajaongkir']['results']
        ]);
    }
}
