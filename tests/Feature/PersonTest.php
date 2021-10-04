<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Person, Planet, Starship};

class PersonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A person can be instantiated test.
     *
     * @return void
     */
    public function testPersonCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Person::class, Person::factory()->make());
    }
    
    /**
     * A person can be created test.
     *
     * @return void
     */
    public function testPersonCanBeCreated(): void
    {
        $person = Person::factory()->create();

        $this->assertDatabaseHas(
            'people',
            [
                'planet_id' => $person->planet_id, 
                'name' => $person->name,
                'height' => $person->height,
                'mass' => $person->mass,
                'hair_color' => $person->hair_color,
                'gender' => $person->gender,
                'homeworld' => $person->homeworld,
            ]
        );
    }

    /**
     * The person belongs to the planet test.
     *
     * @return void
     */
    public function testPersonBelongsToPlanet(): void
    {
        // $person = Person::factory()->has(Planet::factory())->create();
        
        $planet = Planet::factory()->create();
        $person = Person::factory()
            ->for($planet)
            ->create();
        
        $this->assertInstanceOf(Planet::class, $person->planet);
    }

    /**
     * Person has many starships test.
     *
     * @return void
     */
    public function testPersonBelongsToManyStarships(): void
    {
        $person = Person::factory()
            ->has(Starship::factory()->count(3))
            ->create();

        $this->assertInstanceOf(Collection::class, $person->starships);
    }

    // API tests /////////////////////////////////////////////////////////////

    /**
     * People index test.
     *
     * @return void
     */
    public function testApiPeopleIndex(): void
    {
        $this->withoutExceptionHandling();

        Person::factory()->count(3)->create();
        $response = $this->getJson(route('people.index'));
        // $response->dump();
        $response->assertStatus(200);
    }

    /**
     * People store test.
     *
     * @return void
     */
    public function testApiPersonStore(): void
    {
        $this->withoutExceptionHandling();

        $person = Person::factory()->make();
        $response = $this->postJson(route('people.store'), $person->toArray());
        // $response->dump();
        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'created' => true,
                        'person' => ['name' => $person->name]
                    ]
                ]
            );
    }

    /**
     * Person show test.
     *
     * @return void
     */
    public function testApiPersonShow(): void
    {
        $this->withoutExceptionHandling();

        $person = Person::factory()->create();
        $response = $this->getJson(route('people.show', $person));

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'id' => $person->id,
                    'name' => $person->name,
                ]
            ]
        );
    }

    /**
     * Person update test.
     *
     * @return void
     */
    public function testApiPersonUpdate(): void
    {
        $this->withoutExceptionHandling();

        $person = Person::factory()->create();
        $person1 = Person::factory()->make();
        
        $response = $this->putJson(
            route('people.update', $person),
            $person1->toArray()
        );

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'updated' => true,
                    'person' => [
                        'id' => $person->id,
                        'name' => $person1->name
                    ]
                ]
            ]
        );
    }

    /**
     * Person delete test.
     *
     * @return void
     */
    public function testApiPersonDestroy(): void
    {
        $this->withoutExceptionHandling();

        $person = Person::factory()->create();
        $response = $this->deleteJson(route('people.destroy', $person));

        $response->assertStatus(200);
        $response->assertJson(['data' => ['deleted' => true]]);
    }

    // /**
    //  * Search person test.
    //  *
    //  * @return void
    //  */
    // public function testApiPersonSearch(): void
    // {
    //     $this->withoutExceptionHandling();

    //     $people = Person::factory()->count(10)->create();
    //     $response = $this->getJson(
    //         route('people.search', ['search' => $people[0]->name])
    //     );
    //     $response->dump();
    //     $response->assertStatus(200);
    //     // Property [id] does not exist on this collection instance.
    // }
}
