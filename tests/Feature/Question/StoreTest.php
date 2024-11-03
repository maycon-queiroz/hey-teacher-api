<?php

namespace Tests\Feature\Question;

use App\Models\{Question, User};
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

test('after creating a new question, I need to make sure that it creates on _draft_ status', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('questions.store'), [
        'question' => 'How to create a question?',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'question' => 'How to create a question?',
        'status'   => 0,
    ]);
});

describe('validation rules', function () {
    test('question :: required', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store'), [])
            ->assertJsonValidationErrors([
                'question' => 'The question field is required.',
            ]);
    });

    test('question :: ending with question mark', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store'), [
            'question' => 'The question field is required',
        ])
            ->assertJsonValidationErrors([
                'question' => 'Are you sur that is a question? It is missing the question mark in the end.',
            ]);
    });

    test('question :: must be at least 10 characters.', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store'), [
            'question' => 'The que?',
        ])
            ->assertJsonValidationErrors([
                'question' => 'The question field must be at least 10 characters.',
            ]);
    });

    test('question :: should be unique', function () {
        $user     = User::factory()->create();
        $question = Question::Factory()->create([
            'user_id'  => $user->id,
            'question' => 'How to create a question?',
        ]);

        Sanctum::actingAs($user);

        postJson(route('questions.store'), [
            'question' => $question->question,
        ])
            ->assertJsonValidationErrors([
                'question' => 'The question has already been taken.',
            ]);
    });
});
