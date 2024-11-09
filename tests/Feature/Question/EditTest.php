<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, putJson};

it('should be a able to update a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    putJson(route('questions.update', $question), [
        'question' => 'Updating a question?',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'id'       => $question->id,
        'user_id'  => $user->id,
        'question' => 'Updating a question?',
    ]);
});

describe('validation rules', function () {
    test('question :: required', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => '',
        ])
            ->assertJsonValidationErrors([
                'question' => 'The question field is required.',
            ]);
    });

    test('question :: ending with question mark', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'The question field is required',
        ])
            ->assertJsonValidationErrors([
                'question' => 'Are you sur that is a question? It is missing the question mark in the end.',
            ]);
    });

    test('question :: must be at least 10 characters.', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'The que?',
        ])
            ->assertJsonValidationErrors([
                'question' => 'The question field must be at least 10 characters.',
            ]);
    });

    test('question :: should be unique only if id is different', function () {
        $user = User::factory()->create();

        $question = Question::Factory()->create([
            'user_id'  => $user->id,
            'question' => 'How to create a question?',
        ]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'How to create a question?',
        ])->assertOk();
    });
});
