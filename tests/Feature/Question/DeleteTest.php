<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseMissing, deleteJson};

test('should be able to delete a question', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')->create();

    Sanctum::actingAs($user);

    deleteJson(route('questions.destroy', $question))
        ->assertNoContent();

    assertDatabaseMissing('questions', ['id' => $question->id]);
});
