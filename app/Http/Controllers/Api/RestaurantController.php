<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return response()->json($restaurants);
    }

    /**
     * Display a listing of featured restaurants.
     */
    public function featured()
    {
        $featuredRestaurants = Restaurant::where('is_featured', true)->get();
        return response()->json($featuredRestaurants);
    }


    /**
     * Display a listing of nearby halal restaurants.
     */
    public function nearby(Request $request)
    {   
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
        // Validate the radius parameter if provided
        if ($request->has('radius')) {
            $request->validate(['radius' => 'numeric|min:1']);
        }
        // Get latitude, longitude, and radius from the request
        if (!$request->has(['latitude', 'longitude'])) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }
        // Default radius to 5km if not provided
        if (!$request->has('radius')) {
            $request->merge(['radius' => 5]); // default to 5km
        }
        
        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->radius ?? 5; // default 5km radius

        return Restaurant::selectRaw("id, name, address, latitude, longitude, 
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) ) *
                       cos( radians( longitude ) - radians(?) )
                       + sin( radians(?) ) *
                       sin( radians( latitude ) ) ) ) AS distance", [$lat, $lng, $lat])
            ->having("distance", "<", $radius)
            ->orderBy("distance")
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $restaurant = Restaurant::create($request->all());
        return response()->json($restaurant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return response()->json($restaurant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update($request->all());
        return response()->json($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        return response()->json(null, 204);
    }
}
