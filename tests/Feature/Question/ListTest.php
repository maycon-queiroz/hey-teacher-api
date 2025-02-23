<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;

it('should be able to list questions', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $published = Question::factory()->published()->create();
    $draft     = Question::factory()->draft()->create();
    $response  = getJson(route('questions.index'));
    $response->assertOk();
    $response->assertJsonFragment([
        'id'         => $published->id,
        'question'   => $published->question,
        'status'     => $published->status,
        'likes'      => $published->likes,
        'unlikes'    => $published->unlikes,
        'created_by' => [
            'id'   => $published->user->id,
            'name' => $published->user->name,
        ],
        'created_at' => $published->created_at->format('Y-m-d H:i:s'),
        'updated_at' => $published->updated_at->format('Y-m-d H:i:s'),
    ]);
    $response->assertJsonMissing([
        'id' => $draft->id,
    ]);
});

it('should be able search a question', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Question::factory()->published()->create(['question' => 'first question?']);
    Question::factory()->published()->create(['question' => 'second question?']);
    $response = getJson(route('questions.index', ['q' => 'first']));
    $response->assertOk();
    $response->assertJsonFragment(['question' => 'first question?']);
    $response->assertJsonMissing(['question' => 'second question?']);

    $response = getJson(route('questions.index', ['q' => 'second']));
    $response->assertOk();
    $response->assertJsonFragment(['question' => 'second question?']);
    $response->assertJsonMissing(['question' => 'first question?']);
});
