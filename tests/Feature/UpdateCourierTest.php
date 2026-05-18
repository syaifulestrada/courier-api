<?php

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

it('can update a courier', function () {
    $courier = Courier::factory()->create();

    $response = putJson("api/couriers/$courier->id", [
        'name' => 'Edited Name',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('couriers', ['id' => $courier->id, 'name' => 'Edited Name']);
});

it('returns 404 when updating non existing courier', function () {
    $response = putJson('api/couriers/999');

    $response->assertStatus(404);
});

it('cannot update a courier with duplicate email', function () {
    $courier1 = Courier::factory()->create();
    $courier2 = Courier::factory()->create();

    $response = putJson("api/couriers/$courier1->id", [
        'email' => $courier2->email,
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['email']);
});

it('it cannot udpate a courier with duplicate phone', function () {
    $courier1 = Courier::factory()->create();
    $courier2 = Courier::factory()->create();

    $response = putJson("api/couriers/$courier1->id", [
        'phone' => $courier2->phone,
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['phone']);
});
