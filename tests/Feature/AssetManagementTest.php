<?php

use App\Models\User;
use App\Models\Asset;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'administrator']);
    $this->staff = User::factory()->create(['role' => 'staf_operasional']);
    $this->location = Location::factory()->create();
});

test('admin can see assets list', function () {
    $response = $this->actingAs($this->admin)->get('/admin/assets');

    $response->assertStatus(200);
});

test('staff can see assets list', function () {
    $response = $this->actingAs($this->staff)->get('/staf/assets');

    $response->assertStatus(200);
});

test('admin can create asset', function () {
    $assetData = [
        'asset_code' => 'TEST-001',
        'name' => 'Test Asset',
        'category' => 'Electronics',
        'quantity' => 10,
        'unit' => 'Unit',
        'condition' => 'baik',
        'location_id' => $this->location->id,
    ];

    $response = $this->actingAs($this->admin)->post('/admin/assets', $assetData);

    $response->assertRedirect('/admin/assets');
    $this->assertDatabaseHas('assets', ['asset_code' => 'TEST-001']);
});

test('staff cannot create asset', function () {
    $response = $this->actingAs($this->staff)->post('/admin/assets', []);

    // It should be handled by role middleware and return 403 or redirect
    $response->assertStatus(403);
});
