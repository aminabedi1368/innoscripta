<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\NewsArticle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repos\ArticleRepository;

class TheGuardianNewsService
{
    protected $apiKey;
    protected $apiBaseUrl = 'https://content.guardianapis.com/';
    protected $client;
    private ArticleRepository $articleRepository;

    public function __construct(
        ArticleRepository $ArticleRepository
    )
    {
        $this->articleRepository = $ArticleRepository;
        // Set your The Guardian API key here
        $this->apiKey = 'bdbfbded-40ec-4408-a809-46ba11a11c4f';

        $this->client = new Client([
            'base_uri' => $this->apiBaseUrl,
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchNewsArticles($userId, $category = 'news', $pageSize = 100)
    {
        $endpoint = "search";
        $queryParams = [
            'api-key' => $this->apiKey,
            'q' => $category,
            'page-size' => $pageSize,
        ];

        try {
            $response = $this->client->get($endpoint, ['query' => $queryParams]);
            $data = json_decode($response->getBody(), true);

            if (isset($data['response']['results'])) {
                $result=[];
                // Save the articles in the database
                foreach ($data['response']['results'] as $articleData) {
                    $result[] = $this->saveArticleToDatabase($articleData,$category,$userId);
                }
                return $result;
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);
            // Handle the exception (log or throw, depending on your use case)
            return false;
        }
    }

    protected function saveArticleToDatabase($articleData,$category,$userId)
    {
        $validatedData = [
            'source' => 'The Guardian',
            'author' => $articleData['author'] ?? 'No author available',
            'title' => $articleData['webTitle'] ?? 'No title available',
            'description' => $articleData['blocks']['body'][0]['bodyTextSummary'] ?? 'No description available',
            'url' => $articleData['webUrl'] ?? 'No url available',
            'urlToImage' => isset($articleData['blocks']['main']['elements'][0]['assets'][0]['file']) ? $articleData['blocks']['main']['elements'][0]['assets'][0]['file'] : null,
            'published_at' => $articleData['webPublicationDate'] ?? null,
            'content' => $articleData['blocks']['body'][0]['bodyTextSummary'] ?? 'No content available',
            'category' => $category,
            'userId' => $userId,
        ];
        $this->articleRepository->insert($validatedData);
        return $validatedData;
    }
}
