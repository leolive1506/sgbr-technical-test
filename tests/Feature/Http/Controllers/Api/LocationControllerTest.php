<?php

use App\Models\Location;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

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
