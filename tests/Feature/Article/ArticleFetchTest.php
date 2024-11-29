<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleFetchTest extends TestCase
{
    public function test_fetch_articles(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get('articles');

        $response->assertStatus(200);
    }

    public function test_fetch_single_article(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->get('articles/'.$article->id);

        $response->assertStatus(200);
    }
}
