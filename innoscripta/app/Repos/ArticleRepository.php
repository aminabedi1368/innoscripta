<?php

namespace App\Repos;

use App\Entities\NewsArticleEntity;
use App\Models\NewsArticle;
use Illuminate\Support\Facades\Validator;

class ArticleRepository
{
    public function insert($articleData)
    {
         return NewsArticle::createFromJsonArray($articleData);
    }

    // Add other methods related to articles as needed
}
