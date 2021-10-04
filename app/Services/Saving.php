<?php

declare(strict_types = 1);

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Saving
{
    /**
     * Save data to database.
     *
     * @param string $what What
     * 
     * @return boolean
     */
    public function save(string $what): bool
    {
        $success = false;
        if ($what == 'people' || $what == 'planets' || $what == 'starships') {
            $collection = $this->downloadApi($what);
            $success = $this->saveToDatabase($what, $collection);
        }

        return $success;
    }

    /**
     * Download SWAPI.
     *
     * @param string $what What
     * 
     * @return Collection
     */
    private function downloadApi(string $what): Collection
    {
        $response = Http::get("https://swapi.dev/api/{$what}/")->json();
        return collect($response['results']);
    }

    /**
     * Save collection to database.
     *
     * @param String     $what       What
     * @param Collection $collection Collection
     * 
     * @return boolean
     */
    private function saveToDatabase(String $what, Collection $collection): bool
    {
        if ($what == 'people') {
            return $this->savePeople($collection);
        }
        if ($what == 'planets') {
            return $this->savePlanets($collection);
        }
        if ($what == 'starships') {
            return $this->saveStarships($collection);
        }

        return false;
    }

    /**
     * Save people to database.
     *
     * @param Collection $collection Collection.
     * 
     * @return boolean
     */
    private function savePeople(Collection $collection): bool
    {
        $collection->map(
            function ($item, $key) {
                $planetID = Str::between(
                    $item['homeworld'], 'https://swapi.dev/api/planets/', '/'
                );
                $lastInsertId = DB::table('people')
                    ->insertGetId(
                        [
                            'planet_id' => $planetID,
                            'name' => $item['name'],
                            'height' => $item['height'],
                            'mass' => $item['mass'],
                            'hair_color' => $item['hair_color'],
                            'gender' => $item['gender'],
                            'homeworld' => $item['homeworld'],
                        ]
                    );

                foreach ($item['starships'] as $starship) {
                    $starshipID = Str::between(
                        $starship, 'https://swapi.dev/api/starships/', '/'
                    );
                    DB::table('person_starship')
                        ->insert(
                            [
                                'person_id' => $lastInsertId,
                                'starship_id' => $starshipID
                            ]
                        );
                }
            }
        );

        return true;
    }

    /**
     * Save planets to databas.
     *
     * @param Collection $collection Collection
     * 
     * @return boolean
     */
    private function savePlanets(Collection $collection): bool
    {
        $collection->map(
            function ($item, $key) {
                DB::insert(
                    'insert into planets (name, terrain) values (?, ?)',
                    [$item['name'], $item['terrain']]
                );
            }
        );

        return true;
    }

    /**
     * Save starships to database.
     *
     * @param Collection $collection Collection
     * 
     * @return boolean
     */
    private function saveStarships(Collection $collection): bool
    {
        $collection->map(
            function ($item, $key) {
                DB::insert(
                    'insert into starships (name, model) values (?, ?)',
                    [$item['name'], $item['model']]
                );
            }
        );

        return true;
    }
}
