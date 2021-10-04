<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Person, Planet};
use Collator;
use Illuminate\Database\Eloquent\Collection;

class PlanetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A planet can be instantiated test.
     *
     * @return void
     */
    public function testPlanetCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Planet::class, Planet::factory()->make());
    }

    /**
     * A planet can be created
     *
     * @return void
     */
    public function testPlanetCanBeCreated(): void
    {
        $planet = Planet::factory()->create();

        $this->assertDatabaseHas(
            'planets',
            [
                'name' => $planet->name,
                'terrain' => $planet->terrain,
            ]
        );
    }
    
    public function testPlanetHasManyPeople(): void
    {
        $planet = Planet::factory()
            ->has(Person::factory()->count(3))
            ->create();
        
        $this->assertInstanceOf(Collection::class, $planet->people);
    }

    // API tests /////////////////////////////////////////////////////////////

    /**
     * Planet index test.
     *
     * @return void
     */
    public function testApiPlanetIndex(): void
    {
        $this->withoutExceptionHandling();

        Planet::factory()->count(3)->create();
        $response = $this->getJson(route('planets.index'));
        // $response->dump();
        $response->assertStatus(200);
    }

    /**
     * Planet store test.
     *
     * @return void
     */
    public function testApiPlanetStore(): void
    {
        $this->withoutExceptionHandling();

        $planet = Planet::factory()->make();
        $response = $this->postJson(route('planets.store'), $planet->toArray());
        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'created' => true,
                        'planet' => ['name' => $planet->name]
                    ]
                ]
            );
    }

    /**
     * Planet show test.
     *
     * @return void
     */
    public function testApiPlanetShow(): void
    {
        $this->withoutExceptionHandling();

        $planet = Planet::factory()->create();
        $response = $this->getJson(route('planets.show', $planet));

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'id' => $planet->id,
                    'name' => $planet->name,
                ]
            ]
        );
    }

    /**
     * Planet update test.
     *
     * @return void
     */
    public function testApiPlanetUpdate(): void
    {
        $this->withoutExceptionHandling();

        $planet = Planet::factory()->create();
        $planet1 = Planet::factory()->make();
        
        $response = $this->putJson(
            route('planets.update', $planet),
            $planet1->toArray()
        );

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'updated' => true,
                    'planet' => [
                        'id' => $planet->id,
                        'name' => $planet1->name
                    ]
                ]
            ]
        );
    }

    /**
     * Planet delete test.
     *
     * @return void
     */
    public function testApiPlanetDestroy(): void
    {
        $this->withoutExceptionHandling();

        $planet = Planet::factory()->create();
        $response = $this->deleteJson(route('planets.destroy', $planet));

        $response->assertStatus(200);
        $response->assertJson(['data' => ['deleted' => true]]);
    }

    // /**
    //  * Search a planet test.
    //  *
    //  * @return void
    //  */
    // public function testApiPlanetSearch(): void
    // {
    //     $this->withoutExceptionHandling();

    //     $planets = Planet::factory()->count(10)->create();
    //     $response = $this->getJson(
    //         route('planets.search', ['search' => $planets[0]->name])
    //     );
        
    //     $response->assertStatus(200);
    //     // Property [id] does not exist on this collection instance.
    // }
}
