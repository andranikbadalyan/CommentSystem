<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_display_page_for_comments()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_get_all_comments_api_route_exists()
    {
        $response = $this->json('GET', '/api/comments');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_post_a_comment_api_route_exists()
    {
        $response = $this->json('POST', '/api/comments', [
            'name' => 'Andranik Badalyan',
            'comment' => 'Comment is being tested.'
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function gets_all_the_comments_in_descending_order(){
        factory(Comment::class, 10)->create();

        $response = $this->json('GET', '/api/comments')->getData();

        $this->assertEquals('10', $response[0]->id);

    }

    /** @test */
    public function can_store_a_comment_in_database(){
        factory(Comment::class)->create();

        $this->assertDatabaseHas('comments', ['id'=>'1']);
    }

    /** @test */
    public function can_store_a_reply_to_comment(){
        $comment = factory(Comment::class)->create();
        $commentTwo = factory(Comment::class)->create();

        $comment->reply($commentTwo);

        $this->assertDatabaseHas('comments', ['parent_id'=>'2']);
    }

    /** @test */
    public function can_not_store_deeper_than_three_nested_levels(){
        $commentOne = factory(Comment::class)->create();
        $commentTwo = factory(Comment::class)->create();
        $commentThree = factory(Comment::class)->create();
        $commentFour = factory(Comment::class)->create();
        $commentFive = factory(Comment::class)->create();

        $commentOne->reply( $commentTwo );
        $commentTwo->reply( $commentThree );
        $commentThree->reply( $commentFour );
        $disallowedComment=$commentFour->reply( $commentFive );

        $this->assertEquals(true, $disallowedComment);
    }
}
