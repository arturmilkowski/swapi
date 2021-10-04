<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\{PlanetResource, PersonResource};
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PersonResource
     */
    public function index(): AnonymousResourceCollection // PersonResource
    {
        // return new PersonResource(Person::all());
        return PersonResource::collection(Person::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request Request
     * 
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $person = Person::create($request->all());

        return response()->json(
            [
                'data' => [
                    'created' => true,
                    'person' => $person
                ]
            ], 201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Person $person Person
     * 
     * @return PersonResource
     */
    public function show(Person $person): PersonResource
    {
        return new PersonResource($person);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request Request
     * @param Person  $person  Person
     * 
     * @return JsonResponse
     */
    public function update(Request $request, Person $person): JsonResponse
    {
        $person->fill($request->all());
        $person->save();

        $updatedPerson = new PersonResource($person);

        return response()->json(
            [
                'data' => [
                    'updated' => 'true',
                    'person' => $updatedPerson
                ]
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person Person
     * 
     * @return JsonResponse
     */
    public function destroy(Person $person): JsonResponse
    {
        $deleted = $person->delete();
        
        return response()->json(['data' => ['deleted'  => $deleted]], 200);
    }

    /**
     * Search people.
     *
     * @param Request $request Request
     * 
     * @return PersonResource
     */
    public function search(Request $request): PersonResource
    {
        $searchedPhrase = $request->get('search');
        
        $people = DB::table('people')
            ->where('name', 'like', "%{$searchedPhrase}%")
            ->get();
        
        return new PersonResource($people);
    }
}
