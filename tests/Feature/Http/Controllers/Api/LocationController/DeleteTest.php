<?php

use App\Constants\MessagesResponse;
use App\Models\Location;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user);
});

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
