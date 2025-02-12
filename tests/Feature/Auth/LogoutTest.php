<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertGuest, postJson};

it('should be able to logout', function () {
    $user = User::factory()->create(['email' => 'joedoe@doe.com']);

    actingAs($user);

    postJson(route('logout'))
        ->assertNoContent();

    assertGuest('web');

});
