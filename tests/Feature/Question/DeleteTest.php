<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing, deleteJson};

test('should be able to delete a question', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($user);

    deleteJson(route('questions.delete', $question))
        ->assertNoContent();

    assertDatabaseMissing('questions', ['id' => $question->id]);
});

test('should be able to delete a question if user was created', function () {
    $user      = User::factory()->create();
    $userWrong = User::factory()->create();
    $question  = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($userWrong);

    deleteJson(route('questions.delete', $question))
        ->assertForbidden();

    assertDatabaseHas('questions', ['id' => $question->id]);
});
