<?php

use App\Models\User;

use function Pest\Laravel\{assertDatabaseHas, postJson};
use function PHPUnit\Framework\assertTrue;

it('should be abe to registration in the application', function () {

    postJson(route('register'), [
        'name'     => 'John doe',
        'email'    => 'johndoe@example.com',
        'password' => '12345678',
    ])->assertSessionHasNoErrors();

    assertDatabaseHas('users', [
        'name'  => 'John doe',
        'email' => 'johndoe@example.com',
    ]);

    $johnDoe = User::whereEmail('johndoe@example.com')->first();

    assertTrue(\Illuminate\Support\Facades\Hash::check('12345678', $johnDoe->password));
});
