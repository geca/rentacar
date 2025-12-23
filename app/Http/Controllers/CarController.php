<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return Car::with(['provider', 'country', 'city'])->get();
    }

    public function show($id)
    {
        $car = Car::with(['provider', 'country', 'city'])->find($id);
        
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        
        return $car;
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:users,id',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:cars',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'seats' => 'required|integer|min:1|max:20',
            'doors' => 'required|integer|min:2|max:6',
            'daily_rate' => 'required|numeric|min:0',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'sometimes|in:available,rented,maintenance,inactive',
        ]);

        $car = Car::create($request->all());
        
        return response()->json($car->load(['provider', 'country', 'city']), 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $request->validate([
            'provider_id' => 'sometimes|required|exists:users,id',
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'sometimes|required|string|max:255',
            'license_plate' => 'sometimes|required|string|max:255|unique:cars,license_plate,' . $id,
            'transmission' => 'sometimes|required|in:automatic,manual',
            'fuel_type' => 'sometimes|required|in:petrol,diesel,electric,hybrid',
            'seats' => 'sometimes|required|integer|min:1|max:20',
            'doors' => 'sometimes|required|integer|min:2|max:6',
            'daily_rate' => 'sometimes|required|numeric|min:0',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'sometimes|in:available,rented,maintenance,inactive',
        ]);

        $car->update($request->all());
        
        return response()->json($car->load(['provider', 'country', 'city']));
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        
        $car->delete();
        
        return response()->json(['message' => 'Car deleted successfully']);
    }
}
