<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Database\Seeders\PostSeeder;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    
    /**
     * Test add comments.
     *
     * @return void
     */
    public function test_add_comments()
    {
        $faker = Factory::create();

        $comment = [
            'name' => $faker->word(),
            'comment' => $faker->paragraph(500)
        ];

        $response = $this->json('POST', '/api/comments', $comment);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($comment);
    }

    
    /**
     * Test retrieve comments.
     *
     * @return void
     */
    public function test_retrieve_comments()
    {   
        $comment = Comment::factory()
                ->has(
                    Comment::factory()
                        ->count(3)
                        ->state(function (array $attributes, Comment $comment) {
                            return ['comment_id' => $comment->id];
                        })

                )
                ->create();

        $response = $this->get("/api/comments");


        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'comments' => [
                    '*' => [
                        'id',
                        'name',
                        'comment',
                        'created_at',
                        'replies' => [
                            '*' => [
                                'id',
                                'name',
                                'comment',
                                'created_at',
                                'replies' => [
                                    
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

}
