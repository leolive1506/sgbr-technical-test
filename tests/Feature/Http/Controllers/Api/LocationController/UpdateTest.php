<?php

use App\Constants\MessagesResponse;
use App\Models\Location;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

use Illuminate\Support\Str;

beforeEach(function () {
  /** @var User $user */
  $user = User::factory()->create();

  actingAs($user);
});

it('should update an existing location', function () {
    $location = Location::factory()->create();

    $newData = [
        'name' => 'Los Angeles',
        'state' => 'CA',
        'city' => 'Los Angeles',
    ];

    $response = putJson(route('locations.update', $location->id), $newData);

    $udpatedData = [
        'id' => $location->id,
        ...$newData,
        'slug' => Str::slug($newData['name'])
    ];

    $response->assertOk()
        ->assertJsonFragment([
            'content' => $udpatedData,
            'message' => MessagesResponse::UPDATED
        ]);

    assertDatabaseCount(Location::class, 1);

    assertDatabaseHas(Location::class, $udpatedData);
});

it('should validate the request', function (string $property, mixed $value, string $rule, array $attributes = []) {
  $location = Location::factory()->create();

  putJson(route('locations.update', $location->id), [
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
