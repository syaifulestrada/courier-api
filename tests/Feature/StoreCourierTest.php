<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('can create a courier', function () {
    $payload = [
        'name' => 'Budi Santoso',
        'email' => 'budi@mail.com',
        'phone' => '08123456789',
        'level' => 2,
        'address' => 'Jl. Mawar No. 1',
        'is_active' => true,
        'registered_at' => '2024-01-01',
    ];

    $response = postJson('/api/couriers', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('couriers', ['email' => 'budi@mail.com']);
});

it('cannot create a courier with duplicate email', function () {
    $payload = [
        'name' => 'Budi Santoso',
        'email' => 'budi@mail.com',
        'phone' => '08123456789',
        'level' => 2,
        'address' => 'Jl. Mawar No. 1',
        'is_active' => true,
        'registered_at' => '2024-01-01',
    ];

    postJson('/api/couriers', $payload);

    $response = postJson('/api/couriers', $payload);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
