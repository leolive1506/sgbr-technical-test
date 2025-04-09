<?php

use App\Models\Location;
use function Pest\Laravel\getJson;

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
