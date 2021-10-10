<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PlanetResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Planet;

class PlanetController extends Controller
{
    /**
     * Return the planet resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): AnonymousResourceCollection
    {
        // return new PlanetResource(Planet::all());
        $planets = Planet::with('people.planet')->get();
        return PlanetResource::collection($planets);
    }

    /**
     * Store a planet in storage.
     *
     * @param Request $request Request
     * 
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $planet = Planet::create($request->all());

        return response()->json(
            [
                'data' => [
                    'created' => true,
                    'planet' => $planet
                ]
            ], 201
        );
    }

    /**
     * Return the planet resource.
     *
     * @param Planet $planet Planet
     * 
     * @return PlanetResource
     */
    public function show(Planet $planet): PlanetResource
    {
        return new PlanetResource($planet);
    }

    /**
     * Update the planet in storage.
     *
     * @param Request $request Request
     * @param Planet  $planet  Planet
     * 
     * @return JsonResponse
     */
    public function update(Request $request, Planet $planet): JsonResponse
    {
        $planet->fill($request->all());
        $planet->save();

        $updatedPlanet = new PlanetResource($planet);

        return response()->json(
            [
                'data' => [
                    'updated' => 'true',
                    'planet' => $updatedPlanet
                ]
            ], 200
        );
    }

    /**
     * Remove the planet from storage.
     *
     * @param Planet $planet Planet
     * 
     * @return JsonResponse
     */
    public function destroy(Planet $planet): JsonResponse
    {
        $deleted = $planet->delete();
        
        return response()->json(['data' => ['deleted'  => $deleted]], 200);
    }

    /**
     * Return searched planet resource.
     *
     * @param Request $request Request
     * 
     * @return PlanetResource
     */
    public function search(Request $request): PlanetResource
    {
        $searchedPhrase = $request->get('search');
        
        $planets = DB::table('planets')
            ->where('name', 'like', "%{$searchedPhrase}%")
            ->get();
        
        return new PlanetResource($planets);
    }
}
