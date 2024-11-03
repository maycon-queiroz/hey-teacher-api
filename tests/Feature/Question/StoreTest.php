<?php

namespace Tests\Feature\Question;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, postJson};

it('should be a able to store a question', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('questions.store'), [
        'question' => 'How to create a question?',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'question' => 'How to create a question?',
    ]);
});

it('after creating a new question, I need to make sure that it creates on _draft_ status', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('questions.store'), [
        'question' => 'How to create a question?',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id' => $user->id,
        'question' => 'How to create a question?',
        'status' => 0,
    ]);
});
