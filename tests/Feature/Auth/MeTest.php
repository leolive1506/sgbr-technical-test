<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

it('should get user details', function (): void {
    /** @var User */
    $user = User::factory()->create();

    actingAs($user);

    getJson(route('auth.me'))
        ->assertSuccessful()
        ->assertJsonPath('content.user.id', $user->id)
        ->assertJsonPath('content.user.email', $user->email)
        ->assertJsonPath('content.user.name', $user->name);
});
