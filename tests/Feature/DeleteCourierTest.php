<?php

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\deleteJson;

uses(RefreshDatabase::class);

it('can delete a courier', function () {
    $courier = Courier::factory()->create();

    $response = deleteJson("/api/couriers/{$courier->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
});

it('returns 404 when deleting non existing courier', function () {
    $response = deleteJson('/api/couriers/999');

    $response->assertStatus(404);
});
