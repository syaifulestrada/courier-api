<?php

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('can show a courier', function () {
    $courier = Courier::factory()->create();

    $response = getJson("/api/couriers/$courier->id");

    $response->assertStatus(200)
        ->assertJsonFragment(['email' => $courier->email]);
});

it('returns 404 when courier not found', function () {
    $response = getJson('/api/couriers/999');

    $response->assertStatus(404);
});
