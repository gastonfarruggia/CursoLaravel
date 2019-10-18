<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use \App\Models\Post;

class PostTest extends TestCase
{
   use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function stores_post()
    {
      $user = create('App\User');

      $data = [
         'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
         'content' => $this->faker->text($maxNbChars = 40),
         'author_id' => $user->id
      ];

      $response = $this->json('POST', $this->baseUrl . "posts", $data);

      $response->assertStatus(201);
      $this->assertDatabaseHas('posts', $data);

      $post = Post::all()->first();

      $response->assertJson([
         'data' => [
            'id' => $post->id,
            'title' => $post->title
         ]
      ]);
    }

   /**
   * @test
   */
   /*public function deletes_post()
   {
      create('App\User');
      $post = create('App\Models\Post');

      $this->json('DELETE', $this->baseUrl . "posts/{$post->id}")
            ->assertStatus(204);

      $this->assertNull(Post::find($post->id))
   }*/
}
