<?php

use App\Models\Location;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

beforeEach(function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user);
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
