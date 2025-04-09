<?php

use App\Constants\MessagesResponse;
use App\Models\Location;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
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

    $response->assertOk()
        ->assertJsonFragment($newData);

    assertDatabaseCount(Location::class, 1);

    assertDatabaseHas(Location::class, [
        'id' => $location->id,
        ...$newData,
        'slug' => Str::slug($newData['name'])
    ]);
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

