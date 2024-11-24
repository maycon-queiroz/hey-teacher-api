<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, assertNotSoftDeleted, putJson};

test('should be able to publish a question', function () {
    $user     = User::factory()->create();
    $question = Question::Factory()->for($user, 'user')
        ->create(['status' => 1]);

    Sanctum::actingAs($user);

    $response = putJson(route('questions.publish', $question));
    $response->assertOk();

    assertDatabaseHas('questions', ['id' => $question->id, 'status' => 1]);
    $response->assertJsonFragment(['message' => 'Question published successfully']);
});

test('should be able to publish if user is own', function () {
    $user      = User::factory()->create();
    $userWrong = User::factory()->create();

    $question = Question::Factory()->for($user, 'user')
        ->create(['status' => 1]);

    Sanctum::actingAs($userWrong);

    putJson(route('questions.publish', $question))
        ->assertForbidden();

    assertDatabaseHas('questions', ['id' => $question->id, 'status' => 1]);
});

//test( 'should be able not allow publish a question if not archived', function () {
//    $user = User::factory()->create();
//    $question = Question::Factory()->for( $user, 'user' )->create();
//
//    Sanctum::actingAs( $user );
//
//    putJson( route( 'questions.publish', $question ) )
//        ->assertNotFound();
//
//    assertNotSoftDeleted( 'questions', ['id' => $question->id] );
//} );
