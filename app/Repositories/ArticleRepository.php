<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function getLatest(): Collection
    {
        return Article::with('user')->latest()->get();
    }
}