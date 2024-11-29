<?php

namespace Tests\Feature\Article;

use App\Models\User;
use Tests\TestCase;

class ArticleCreateTest extends TestCase
{
    public function test_article_create(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post('/articles/', [
                'title' => 'Test Title',
                'content' => 'Test Content',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/articles');
    }

    public function test_article_create_fail_with_no_title(): void
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->post('/articles/', [
                'content' => 'Test Content',
            ]);

        $response
            ->assertSessionHasErrors();
    }
}
