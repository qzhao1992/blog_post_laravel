<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhenThereis1(){
        //arrange
        $post = $this->createDummyBlogPost();

        //act
        $response = $this->get('/posts');

        //assert
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts',[
            'title' => 'New title'
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();
        Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid(){
        $user = $this->user();
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];
        $this->actingAs($user);

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
    $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
        ->post('/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        // dd($messages->getMessages())
        
        $this->assertEquals($messages['title'][0], "The title must be at least 5 characters.");
        $this->assertEquals($messages['content'][0], "The content must be at least 10 characters.");
    }

    public function testUpdateValid(){
        $this->actingAs($this->user());
        //arrange
        $post = $this->createDummyBlogPost();

        // $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->actingAs($this->user())
        ->put("/posts/{$post->id}", $params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title'
        ]);
    }

    public function testDelete(){
        $post = $this->createDummyBlogPost();
        // $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->actingAs($this->user())->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), "Blog post was delete!");
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = "New title";
        // $post->content = 'Content of the blog post';
        // $post->save();

        return BlogPost::factory()->NewTitle()->create();

        // return $post;
    }
}
