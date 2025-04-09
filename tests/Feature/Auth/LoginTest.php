<?php

use App\Models\User;

use function Pest\Laravel\postJson;

beforeEach(function () {
    User::factory()->create([
        'email'    => 'john@doe.com',
        'password' => 'password',
    ]);
});

it('should be able to login', function () {
    postJson(route('auth.login'), [
        'email'    => 'john@doe.com',
        'password' => 'password',
    ])->assertOk();
});

it('should not be able to login with invalid credentials', function () {
    postJson(route('auth.login'), [
        'email'    => 'john@doe.com',
        'password' => 'wrong-password',
    ])->assertUnprocessable();
});

it('should be able to return token', function () {
    postJson(route('auth.login'), [
        'email'    => 'john@doe.com',
        'password' => 'password',
    ])->assertJsonStructure([
        'message',
        'status',
        'content' => [
            'token',
            'user'
        ],
    ]);
});

it('should be able to validate the request', function (string $property, mixed $value, string $rule) {
    postJson(route('auth.login'), [
        $property => $value,
    ])->assertJsonValidationErrors([
        $property => __("validation.{$rule}", ['attribute' => $property]),
    ]);
})->with([
    'email:required' => ['email', '', 'required'],
    'email:email'    => ['email', 'notemail', 'email'],

    'password:required' => ['password', '', 'required'],
    'password:string'   => ['password', 123, 'string'],
]);
