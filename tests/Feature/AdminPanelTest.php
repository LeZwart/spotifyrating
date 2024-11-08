<?php

use App\Models\User;

test('A guest cannot access the admin panel', function () {
    $response = $this->get('/admin');

    $response->assertForbidden();
});

test('A user cannot access the admin panel', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/admin');

    $response->assertForbidden();
});

test('An admin can access the admin panel', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin');

    $response->assertOk();
});

test('A user cannot access the admin users page', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/admin/users');

    $response->assertForbidden();
});

test('An admin can access the admin users page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin/users');

    $response->assertOk();
});

test('A user cannot delete a user', function () {
    $user = User::factory()->create();
    $userToDelete = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete("/admin/users/{$userToDelete->id}");

    $response->assertForbidden();
});

test('An admin can delete a user', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);
    $userToDelete = User::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->delete("/admin/users/{$userToDelete->id}");

    $response->assertRedirect('/admin/users');
});

test('A user cannot view user edit page', function () {
    $user = User::factory()->create();
    $userToEdit = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get("/admin/users/{$userToEdit->id}/edit");

    $response->assertForbidden();
});

test('An admin can view user edit page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);
    $userToEdit = User::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->get("/admin/users/{$userToEdit->id}/edit");

    $response->assertOk();
});

test('A user cannot update a user', function () {
    $user = User::factory()->create();
    $userToUpdate = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch("/admin/users/{$userToUpdate->id}");

    $response->assertForbidden();
});

test('An admin can update a user', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);
    $userToUpdate = User::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->patch("/admin/users/{$userToUpdate->id}", [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);

    $response->assertRedirect('/admin/users');
});
