<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, postJson};

it('should be able to vote a question', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $question = Question::factory()->published()->create();

    $response = postJson(route('questions.like', $question));
    $response->assertCreated();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});
