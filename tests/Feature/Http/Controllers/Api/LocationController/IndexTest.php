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
                ],
                'paginate',
            ]
        ]);
});


it('should filter location by name', function () {
    $locations = Location::factory()->count(3)->create();

    $locations->each(function (Location $location) {
        $response = getJson(route('locations.index', [
            'name' => $location->name
        ]));

        $response->assertOk()
            ->assertJsonCount(1, 'content.data')
            ->assertJson([
                'content' => [
                    'data' => [
                        '0' => [
                            'id' => $location->id,
                            'name' => $location->name,
                            'slug' => $location->slug,
                            'state' => $location->state,
                            'city' => $location->city,
                        ]
                    ]
                ]
            ]);
    });
});

