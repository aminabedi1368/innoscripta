<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repos\ArticleRepository;


class BBCNewsService
{
    protected $apiKey;
    protected $apiBaseUrl = 'https://newsapi.org/v2/';
    protected $client;
    private ArticleRepository $articleRepository;

    public function __construct(
        ArticleRepository $ArticleRepository
    )
    {
        $this->articleRepository = $ArticleRepository;
        // Set your BBC News API key here
        $this->apiKey = 'a4fceca0a1d144619a0e3b31f5e65130';

        $this->client = new Client([
            'base_uri' => $this->apiBaseUrl,
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchNewsArticles($userId,$category = 'general', $pageSize = 100)
    {
        $endpoint = "everything";
        $queryParams = [
            'apiKey' => $this->apiKey,
            'q' => $category,
            'pageSize' => $pageSize,
        ];

        try {
            $response = $this->client->get($endpoint, ['query' => $queryParams]);
            $data = json_decode($response->getBody(), true);

            if (isset($data['articles'])) {
                $result=[];
                foreach ($data['articles'] as $articleData) {
                    $result[]=$this->saveArticleToDatabase($articleData,$category,$userId);
                }
                return $result;
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            // Handle the exception (log or throw, depending on your use case)
            return false;
        }
    }

    protected function saveArticleToDatabase($articleData , $category,$userId)
    {
        $validatedData =[
            'source' => $articleData['source']['name'] ?? 'No source available',
            'author' => $articleData['author'] ?? 'No author available',
            'title' => $articleData['title'] ?? 'No title available',
            'description' => $articleData['description'] ?? 'No description available',
            'url' => $articleData['url'] ?? 'No url available',
            'urlToImage' => $articleData['urlToImage'] ?? null,
            'published_at' => $articleData['publishedAt'] ?? 'No urlToImage available' ,
            'content' => $articleData['content'] ?? 'No content available',
            'category' =>$category,
            'userId' =>$userId,
        ];
        $this->articleRepository->insert($validatedData);
        return $validatedData;

    }

}
