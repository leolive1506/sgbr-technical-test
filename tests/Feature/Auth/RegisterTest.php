<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be able to register a user', function () {
    Notification::fake();

    postJson(route('auth.register'), [
        'name'     => 'John Doe',
        'email'    => 'john@doe.com',
        'password' => 'password',
    ])->assertJsonStructure([
        'message',
        'status',
        'content' => [
            'token',
            'user'
        ],
    ])->assertCreated();

    assertDatabaseCount(User::class, 1);

    assertDatabaseHas(User::class, [
        'name'     => 'John Doe',
        'email'    => 'john@doe.com',
    ]);

    $user = User::first()->makeVisible('password');

    expect(Hash::isHashed($user->password))->toBeTrue();
    expect(Hash::check('password', $user->password))->toBeTrue();
});

it('should validate the request', function (string $property, mixed $value, string $rule) {
    if (str_contains($rule, 'unique')) {
        User::factory()->create([$property => $value]);
    }

    postJson(route('auth.register'), [
        $property => $value,
    ])->assertJsonValidationErrors([
        $property => __("validation.{$rule}", ['attribute' => $property]),
    ]);
})->with([
    'name:required' => ['name', '', 'required'],
    'name:string'   => ['name', 123, 'string'],

    'email:required' => ['email', '', 'required'],
    'email:string'   => ['email', 123, 'string'],
    'email:email'    => ['email', 'invalid-email', 'email'],
    'email:unique'   => ['email', 'john@doe.com', 'unique'],

    'password:required' => ['password', '', 'required'],
    'password:string'   => ['password', 123, 'string'],
]);
