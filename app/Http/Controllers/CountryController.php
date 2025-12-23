<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'API is working!']);
    }

    public function index()
    {
        return Country::with(relations: 'cities')->get();
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        return Country::create($requestData);
    }

    public function update(Request $request, $id)
    {
        $country = Country::find($id);
        $country->update($request->all());
        return $country;
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return response()->json(['message' => 'Country deleted successfully']);
    }
}

