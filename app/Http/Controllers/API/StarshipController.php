<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StarshipResource;
use App\Models\Starship;

class StarshipController extends Controller
{
    /**
     * Return the starship resource.
     *
     * @return StarshipResource
     */
    public function index(): StarshipResource
    {
        return new StarshipResource(Starship::all());
    }

    /**
     * Store a starship in storage.
     *
     * @param Request $request Request
     * 
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $starship = Starship::create($request->all());

        return response()->json(
            [
                'data' => [
                    'created' => true,
                    'starship' => $starship
                ]
            ], 201
        );
    }

    /**
     * Return the starship resource.
     *
     * @param Starship $starship Starship
     * 
     * @return StarshipResource
     */
    public function show(Starship $starship): StarshipResource
    {
        return new StarshipResource($starship);
    }

    /**
     * Update the starship in storage.
     *
     * @param Request  $request  Request
     * @param Starship $starship Starship
     * 
     * @return JsonResponse
     */
    public function update(Request $request, Starship $starship): JsonResponse
    {
        $starship->fill($request->all());
        $starship->save();

        $updatedStarship = new StarshipResource($starship);

        return response()->json(
            [
                'data' => [
                    'updated' => 'true',
                    'starship' => $updatedStarship
                ]
            ], 200
        );
    }

    /**
     * Remove the starship from storage.
     *
     * @param Starship $starship Starship
     * 
     * @return void
     */
    public function destroy(Starship $starship): JsonResponse
    {
        $deleted = $starship->delete();
        
        return response()->json(['data' => ['deleted'  => $deleted]], 200);
    }

    /**
     * Search starships by name.
     *
     * @param Request $request Request
     * 
     * @return StarshipResource
     */
    public function search(Request $request): StarshipResource
    {
        $searchedPhrase = $request->get('search');
        
        $starships = DB::table('starships')
            ->where('name', 'like', "%{$searchedPhrase}%")
            ->get();
        
        return new StarshipResource($starships);
    }
}
