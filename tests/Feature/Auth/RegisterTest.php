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

describe('validations', function () {
    test('name', function ($rule, $value, $meta = []) {
        postJson(route('register'), ['name' => $value])
            ->assertJsonValidationErrors([
                'name' => [__(
                    'validation.' . $rule,
                    array_merge(['attribute' => 'name'], $meta)
                )],
            ]);
    })->with([
        'required' => ['required', ''],
        'min:3'    => ['min', 'ad', ['min' => 3]],
        'max:255'  => ['max', str_repeat('*', 256), ['max' => 255]],
        ]);

    test('email', function ($rule, $value, $meta = []) {
        postJson(route('register'), ['email' => $value])
            ->assertJsonValidationErrors([
                'email' => [__(
                    'validation.' . $rule,
                    array_merge(['attribute' => 'email'], $meta)
                )],
            ]);
    })->with([
        'required' => ['required', ''],
        'min:3'    => ['min', 'ad', ['min' => 3]],
        'max:255'  => ['max', str_repeat('*', 256), ['max' => 255]],
        'email'  => ['email', 'no-email'],
    ]);

});
