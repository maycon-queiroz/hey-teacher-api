<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertNotSoftDeleted, assertSoftDeleted, putJson};

test('should be able to restore a question', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($user);

    $question->delete();

    assertSoftDeleted('questions', ['id' => $question->id]);

    $response = putJson(route('questions.restore', $question));
    $response->assertOk();

    assertNotSoftDeleted('questions', ['id' => $question->id]);
    $response->assertJsonFragment(['message' => 'Question restored successfully']);

});

test('should be able to restore if user was created', function () {
    $user      = User::factory()->create();
    $userWrong = User::factory()->create();
    $question  = Question::Factory()->for($user, 'user')->create();

    $question->delete();
    assertSoftDeleted('questions', ['id' => $question->id]);

    Sanctum::actingAs($userWrong);

    putJson(route('questions.restore', $question))
        ->assertForbidden();

    assertSoftDeleted('questions', ['id' => $question->id]);
});

test('should be able not allow restore a question if not archived', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($user);

    putJson(route('questions.restore', $question))
        ->assertNotFound();

    assertNotSoftDeleted('questions', ['id' => $question->id]);
});
