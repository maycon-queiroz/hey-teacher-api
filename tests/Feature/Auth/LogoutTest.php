<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

it('should be able to logout', function () {
    $user = User::factory()->create(['email' => 'joedoe@doe.com']);

    Sanctum::actingAs($user);
    $user->refresh();

    \Pest\Laravel\assertAuthenticatedAs($user, 'sanctum');

    postJson(route('logout'), [], [
        'Accept'        => 'application/json',
        'Authorization' => 'Bearer ' . $user->tokens,
    ])->assertNoContent();

});
