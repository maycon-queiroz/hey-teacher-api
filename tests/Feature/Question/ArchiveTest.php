<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{
    assertNotSoftDeleted,
    assertSoftDeleted,
    deleteJson};

test('should be able to archive a question', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($user);

    deleteJson(route('questions.archive', $question))
        ->assertNoContent();

    assertSoftDeleted('questions', ['id' => $question->id]);
});

test('should be able to delete a archive if user was created', function () {
    $user      = User::factory()->create();
    $userWrong = User::factory()->create();
    $question  = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($userWrong);

    deleteJson(route('questions.archive', $question))
        ->assertForbidden();

    assertNotSoftDeleted('questions', ['id' => $question->id]);
});
