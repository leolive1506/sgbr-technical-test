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

it('should create a new location', function () {
    $data = [
        'name' => 'New York',
        'state' => 'NY',
        'city' => 'New York City',
    ];

    $response = postJson('/api/locations', $data);

    $response->assertCreated()
        ->assertJsonFragment([
            'message' => MessagesResponse::CREATED
        ])
        ->assertJsonFragment($data);

    assertDatabaseHas(Location::class, [
        ...$data,
        'slug' => Str::slug($data['name'])
    ]);
});

it('should update an existing location', function () {
    $location = Location::factory()->create();

    $newData = [
        'name' => 'Los Angeles',
        'state' => 'CA',
        'city' => 'Los Angeles',
    ];

    $response = putJson("/api/locations/{$location->id}", $newData);

    $udpatedData = [
        'id' => $location->id,
        ...$newData,
        'slug' => Str::slug($newData['name'])
    ];

    $response->assertOk()
        ->assertJsonFragment([
            'content' => $udpatedData,
            'message' => MessagesResponse::UPDATED
        ]);

    assertDatabaseCount(Location::class, 1);

    assertDatabaseHas(Location::class, $udpatedData);
});

it('should delete a location', function () {
    $location = Location::factory()->create();

    $response = deleteJson("/api/locations/{$location->id}");

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

    $response = getJson("/api/locations/{$location->id}");

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

    $response = getJson('/api/locations');

    $response->assertOk()
        ->assertJsonStructure([
            'content' => [
                'data' => [
                    '*' => ['id', 'name', 'slug', 'state', 'city']
                ]
            ]
        ]);
});
