<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CountryCityStateController extends Controller
{
    public function searchCountries(): \Illuminate\Http\JsonResponse
    {
        $countries = Country::all();
        return response()->json($countries, 200);
    }

    public function searchStates(int $countryId)
    {
        $states = State::where('country_id', '=', $countryId)->get();
        return response()->json($states, 200);
    }

    public function searchCities(int $stateId)
    {
        $city = City::where('state_id', '=', $stateId)->get();
        return response()->json($city, 200);
    }
}
