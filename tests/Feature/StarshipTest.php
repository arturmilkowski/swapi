<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Starship, Person};

class StarshipTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A starship can be instantiated test.
     *
     * @return void
     */
    public function testStarshipCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Starship::class, Starship::factory()->make());
    }
    
    /**
     * A starship can be created test.
     *
     * @return void
     */
    public function testStarshipCanBeCreated(): void
    {
        $starship = Starship::factory()->create();

        $this->assertDatabaseHas(
            'starships',
            [
                'name' => $starship->name,
                'model' => $starship->model,
            ]
        );
    }

    /**
     * Starships belongs to many people test.
     *
     * @return void
     */
    public function testStarshipBelongsToManyPerson(): void
    {
        $starships = Starship::factory()->count(3)->create();
        Person::factory()
            ->count(3)
            ->hasAttached($starships)
            ->create();
        
        $this->assertInstanceOf(Collection::class, $starships[0]->people);
    }

    // API tests /////////////////////////////////////////////////////////////

    /**
     * Starship index test.
     *
     * @return void
     */
    public function testApiStarshipIndex(): void
    {
        $this->withoutExceptionHandling();

        Starship::factory()->count(3)->create();
        $response = $this->getJson(route('starships.index'));

        $response->assertStatus(200);
    }

    /**
     * Starship store test.
     *
     * @return void
     */
    public function testApiStarshipStore(): void
    {
        $this->withoutExceptionHandling();

        $starship = Starship::factory()->make();
        $response = $this->postJson(route('starships.store'), $starship->toArray());
        
        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'created' => true,
                        'starship' => ['name' => $starship->name]
                    ]
                ]
            );
    }

    /**
     * Starship show test.
     *
     * @return void
     */
    public function testApiStarshipShow(): void
    {
        $this->withoutExceptionHandling();

        $starship = Starship::factory()->create();
        $response = $this->getJson(route('starships.show', $starship));

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'id' => $starship->id,
                    'name' => $starship->name,
                ]
            ]
        );
    }

    /**
     * Starship update test.
     *
     * @return void
     */
    public function testApiStarshipUpdate(): void
    {
        $this->withoutExceptionHandling();

        $starship = Starship::factory()->create();
        $starship1 = Starship::factory()->make();
        
        $response = $this->putJson(
            route('starships.update', $starship),
            $starship1->toArray()
        );

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'updated' => true,
                    'starship' => [
                        'id' => $starship->id,
                        'name' => $starship1->name
                    ]
                ]
            ]
        );
    }

    /**
     * Starship delete test.
     *
     * @return void
     */
    public function testApiStarshipDestroy(): void
    {
        $this->withoutExceptionHandling();

        $starship = Starship::factory()->create();
        $response = $this->deleteJson(route('starships.destroy', $starship));

        $response->assertStatus(200);
        $response->assertJson(['data' => ['deleted' => true]]);
    }

    // /**
    //  * Search a starship test.
    //  *
    //  * @return void
    //  */
    // public function testApiStarshipSearch(): void
    // {
    //     $this->withoutExceptionHandling();

    //     $starships = Starship::factory()->count(10)->create();
    //     $response = $this->getJson(
    //         route('starships.search', ['search' => $starships[0]->name])
    //     );
        
    //     $response->assertStatus(200);
    //     // Property [id] does not exist on this collection instance.
    // }
}
