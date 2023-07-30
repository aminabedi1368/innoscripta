<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\NewsArticle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repos\ArticleRepository;

class NewYorkTimesService
{
    protected $apiKey;
    protected $apiBaseUrl = 'https://api.nytimes.com/svc/search/v2/';
    protected $client;
    private ArticleRepository $articleRepository;

    public function __construct(
        ArticleRepository $ArticleRepository
)
    {
        $this->articleRepository = $ArticleRepository;
        // Set your New York Times API key here
        $this->apiKey = '5jayl0VjMgOZGs7w9dpm4SkoeR6oq1O6';

        $this->client = new Client([
            'base_uri' => $this->apiBaseUrl,
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchNewsArticles($userId, $category = 'news', $pageSize = 100 , $page = 1)
    {
        $endpoint = "articlesearch.json";
        $queryParams = [
            'api-key' => $this->apiKey,
            'page' => $page,
        ];
        if ($category) {
            $queryParams['q'] = $category;
        }

        try {
            $response = $this->client->get($endpoint, ['query' => $queryParams]);
            $data = json_decode($response->getBody(), true);
            if (isset($data['response']['docs'])) {
                $result=[];
                // Save the articles in the database
                foreach ($data['response']['docs'] as $articleData) {
                    $result[] = $this->saveArticleToDatabase($articleData,$category,$userId);
                }
                return $result;
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            // Handle the exception (log or throw, depending on your use case)
            return $errorMessage;
        }
    }

    protected function saveArticleToDatabase($articleData,$category,$userId)
    {
        $validatedData = [
            'source' => 'The New York Times',
            'author' => $articleData['byline']['original'] ?? 'No author available',
            'title' => $articleData['headline']['main'] ?? 'No title available',
            'description' => $articleData['abstract'] ?? 'No description available',
            'url' => $articleData['web_url'] ?? 'No url available',
            'urlToImage' => isset($articleData['multimedia'][0]['url']) ? 'https://www.nytimes.com/' . $articleData['multimedia'][0]['url'] : null,
            'published_at' => $articleData['pub_date'] ?? null,
            'content' => $articleData['lead_paragraph'] ?? 'No content available',
            'category'=>$category,
            'userId'=>$userId
        ];
        $this->articleRepository->insert($validatedData);
        return $validatedData;
    }


}
