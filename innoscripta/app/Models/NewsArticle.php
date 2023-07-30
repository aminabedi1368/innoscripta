<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class NewsArticle extends Model
{

    protected $fillable = [
        'source',
        'author',
        'title',
        'description',
        'url',
        'urlToImage',
        'published_at',
        'content',
        'category',
        'userId'
    ];

    public static function createFromJsonArray(array $data)
    {
        $validator = Validator::make($data, [
            'url' => 'required|unique:news_articles,url',
        ]);

        if ($validator->fails()) {
            return false;
        }

        return static::create([
            'source' => $data['source'],
            'author' => $data['author'],
            'title' => $data['title'],
            'description' => $data['description'],
            'url' => $data['url'],
            'urlToImage' => $data['urlToImage'] ?? null,
            'published_at' => $data['published_at'],
            'content' => $data['content'],
            'category' => $data['category'],
            'userId' => $data['userId'] ?? null
        ]);
    }
}
