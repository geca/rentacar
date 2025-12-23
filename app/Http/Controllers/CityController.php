<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'API is working!']);
    }

    public function index()
    {
        return City::get();
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        return City::create($requestData);
    }

    public function update(Request $request, $id)
    {
        $city = City::find($id);
        $city->update($request->all());
        return $city;
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        return response()->json(['message' => 'City deleted successfully']);
    }
}
