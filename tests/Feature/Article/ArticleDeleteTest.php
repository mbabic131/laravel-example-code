<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleDeleteTest extends TestCase
{
    public function test_article_delete(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $response = $this
            ->actingAs($user)
            ->delete('/articles/'.$article->id);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/articles');
    }
}
