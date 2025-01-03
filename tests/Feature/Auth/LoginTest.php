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

it('should not be able to login with invalid credentials', function () {
    User::factory()->create([
        'email'    => 'johndoe@doe.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);

    PostJson('/login', ['email' => 'johndoe@doe.com', 'password' => '<PASSWORD>'])
        ->assertJsonValidationErrors([
            'email' => [__('auth.failed')],
        ]);
})
->with([
    'email_wrong'    => ['johndoe_wrong@doe.com', 'password'],
    'password_wrong' => ['johndoe@doe.com', 'password_wrong'],
    'email_ivalid'   => ['johndoedoe.com', 'password'],
]);

test('should not be able to login if params not is provided', function () {
    PostJson('/login', ['email' => '', 'password' => ''])
        ->assertJsonValidationErrors([
            'email' => [__('auth.failed')],
        ]);
});
