<?php

namespace App\Listeners;

use App\Events\ArticleCreated;
use App\Models\User;
use App\Notifications\NewArticle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendArticleCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticleCreated $event): void
    {
        foreach (User::whereNot('id', $event->article->user_id)->cursor() as $user) {
            $user->notify(new NewArticle($event->article));
        }
    }
}
