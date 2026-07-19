<?php

use App\Models\Category;
use App\Models\User;

it('shows categories on the index page', function () {
    $user = User::factory()->create();
    $category = Category::create([
        'name' => 'Electronics',
        'slug' => 'electronics',
        'description' => 'Gadgets',
        'status' => 1,
    ]);

    $response = $this->actingAs($user)->get('/categories');

    $response->assertOk();
    $response->assertSee($category->name);
});
