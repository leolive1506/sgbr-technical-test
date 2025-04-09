<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;

it('should remove the user device token when logging out', function (): void {
    /** @var User */
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('auth.logout'))
        ->assertSuccessful();

    assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);
});
