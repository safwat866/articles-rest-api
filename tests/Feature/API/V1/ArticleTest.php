<?php

namespace Tests\Feature\API\V1;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_paginated_articles(): void
    {
        $user = User::factory()->create();
        Article::factory()->count(15)->create([
            'user_id' => $user->id,
            'published' => true,
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'body', 'published', 'min-to-read', 'author'],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_show_returns_article(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/v1/articles/{$article->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $article->id,
                    'title' => $article->title,
                ],
            ]);
    }

    public function test_store_creates_new_article(): void
    {
        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'published' => true,
            'min_to_read' => 5,
        ];

        $response = $this->actingAs($user)->postJson('/api/v1/articles', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => $data['title'],
                    'body' => $data['body'],
                ],
            ]);

        $this->assertDatabaseHas('articles', [
            'title' => $data['title'],
        ]);
    }

    public function test_update_modifies_article(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $data = [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'published' => false,
            'min_to_read' => 10,
        ];

        $response = $this->actingAs($user)->putJson("/api/v1/articles/{$article->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'Updated Title',
                ],
            ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_destroy_deletes_article(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/v1/articles/{$article->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }
}
