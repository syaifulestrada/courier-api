<?php

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('can list couriers', function () {
    Courier::factory()->count(15)->create();

    $response = getJson('api/couriers');

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'email',
                'phone',
                'level',
                'address',
                'is_active',
                'registered_at',
            ],
        ],
        'current_page',
        'total',
        'per_page',
        'last_page',
        'next_page_url',
    ]);
});
