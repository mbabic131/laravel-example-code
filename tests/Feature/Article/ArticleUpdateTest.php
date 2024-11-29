<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleUpdateTest extends TestCase
{
    public function test_article_update(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $response = $this
            ->actingAs($user)
            ->put('/articles/'.$article->id, [
                'title' => 'Test Title',
                'content' => 'Test Content',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/articles');

        $article->refresh();

        $this->assertSame('Test Title', $article->title);
        $this->assertSame('Test Content', $article->content);
    }
}
