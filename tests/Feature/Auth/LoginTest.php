<?php

use App\Models\User;

use function Pest\Laravel\{assertAuthenticated,assertAuthenticatedAs, postJson};

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'johndoe@doe.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);

    PostJson('/login', ['email' => 'johndoe@doe.com', 'password' => 'password'])
        ->assertNoContent();

    assertAuthenticated('web');
    assertAuthenticatedAs($user);

});
