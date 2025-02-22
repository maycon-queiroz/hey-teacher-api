<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;

it('should able list only questions taht the logged has been created :: published', function () {
    $user           = User::factory()->create();
    $userWrong      = User::factory()->create();
    $published      = Question::factory()->for($user)->published()->create();
    $publishedWrong = Question::factory()->for($userWrong)->published()->create();
    $draft          = Question::factory()->draft()->create();
    $archived       = Question::factory()->archived()->create();

    Sanctum::actingAs($user);

    $response = getJson(route('questions.my-questions', ['status' => 'published']));
    $response->assertOk();
    $response->assertJsonFragment([
        'id'         => $published->id,
        'question'   => $published->question,
        'status'     => 'publish',
        'created_by' => [
            'id'   => $published->user->id,
            'name' => $published->user->name,
        ],
        'created_at' => $published->created_at->format('Y-m-d H:i:s'),
        'updated_at' => $published->updated_at->format('Y-m-d H:i:s'),
    ]);
    $response->assertJsonMissing([
        'id'     => $draft->id,
        'status' => 'draft',
    ]);

    $response->assertJsonMissing([
        'id' => $publishedWrong->id,
    ]);

    $response->assertJsonMissing([
        'id' => $archived->id,
    ]);
});

it('should able list only questions taht the logged has been created :: draft', function () {
    $user       = User::factory()->create();
    $userWrong  = User::factory()->create();
    $draft      = Question::factory()->for($user)->draft()->create();
    $draftWrong = Question::factory()->for($userWrong)->draft()->create();
    $archived   = Question::factory()->archived()->create();

    Sanctum::actingAs($user);

    $response = getJson(route('questions.my-questions', ['status' => 'draft']));
    $response->assertOk();
    $response->assertJsonFragment([
        'id'         => $draft->id,
        'question'   => $draft->question,
        'status'     => 'draft',
        'created_by' => [
            'id'   => $draft->user->id,
            'name' => $draft->user->name,
        ],
        'created_at' => $draft->created_at->format('Y-m-d H:i:s'),
        'updated_at' => $draft->updated_at->format('Y-m-d H:i:s'),
    ]);
    $response->assertJsonMissing([
        'status' => 'publish',
    ]);

    $response->assertJsonMissing([
        'id' => $draftWrong->id,
    ]);

    $response->assertJsonMissing([
        'id' => $archived->id,
    ]);
});
