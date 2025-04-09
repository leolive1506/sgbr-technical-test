<?php

use App\Constants\MessagesResponse;
use App\Models\Location;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

use Illuminate\Support\Str;

it('should delete a location', function () {
    $location = Location::factory()->create();

    $response = deleteJson(route('locations.destroy', $location->id));

    $response->assertOk()
        ->assertJsonFragment([
            'message' => MessagesResponse::DELETED
        ]);

    assertSoftDeleted(Location::class, [
        'id' => $location->id
    ]);
});

it('should find location by id', function () {
    $location = Location::factory()->create();

    $response = getJson(route('locations.show', $location->id));

    $response->assertOk()
        ->assertJsonFragment([
            'id' => $location->id,
            'name' => $location->name,
            'slug' => $location->slug,
            'state' => $location->state,
            'city' => $location->city,
        ]);
});

it('should list location paginated', function () {
    Location::factory()->count(3)->create();

    $response = getJson(route('locations.index'));

    $response->assertOk()
        ->assertJsonStructure([
            'content' => [
                'data' => [
                    '*' => ['id', 'name', 'slug', 'state', 'city']
                ]
            ]
        ]);
});
