<?php

use App\Constants\MessagesResponse;
use App\Models\Location;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

use Illuminate\Support\Str;


beforeEach(function () {
  /** @var User $user */
  $user = User::factory()->create();

  actingAs($user);
});

it('should create a new location', function () {
    $data = [
        'name' => 'New York',
        'state' => 'NY',
        'city' => 'New York City',
    ];

    $response = postJson(route('locations.index'), $data);

    $response->assertCreated()
        ->assertJsonFragment([
            'message' => MessagesResponse::CREATED
        ])
        ->assertJsonFragment($data);

    assertDatabaseHas(Location::class, [
        ...$data,
        'slug' => Str::slug($data['name'])
    ]);
});

it('should validate the request', function (string $property, mixed $value, string $rule, array $attributes = []) {
  postJson(route('locations.store'), [
      $property => $value,
  ])->assertJsonValidationErrors([
      $property => __("validation.{$rule}", [
        'attribute' => $property,
        ...$attributes
      ]),
  ]);
})->with([
  'name:required' => ['name', '', 'required'],
  'name:string'   => ['name', 123, 'string'],
  'name:max' => ['name', str('a')->repeat(156), 'max.string', [
    'max' => 150
  ]],

  'state:required' => ['state', '', 'required'],
  'state:string'   => ['state', 123, 'string'],
  'state:max' => ['state', str('a')->repeat(256), 'max.string', [
    'max' => 255
  ]],

  'city:required' => ['city', '', 'required'],
  'city:string'   => ['city', 123, 'string'],
  'city:max' => ['city', str('a')->repeat(256), 'max.string', [
    'max' => 255
  ]],
]);
