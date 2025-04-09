<?php

use App\Models\Location;

use function Pest\Laravel\getJson;

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
