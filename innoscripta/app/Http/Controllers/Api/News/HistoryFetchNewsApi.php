<?php

namespace App\Http\Controllers\Api\News;

use Illuminate\Http\Request;
use App\Models\NewsArticle;

class HistoryFetchNewsApi
{

    public function __construct()
    {}
    public function __invoke(Request $request)
    {
        $userEntity = $request->attributes->get('userEntity');
        $userId = $userEntity->getId();

        $categoryFilter = $request->input('categoryFilter', 'general');
        $timeFilter = $request->input('timeFilter'); // Time filter value, e.g., 'today', 'week', 'month'
        $pageSize = $request->input('pageSize', 10);
        $pageNumber = $request->input('page', 1);

        // Start building the query for fetching news articles with the given userId
        $query = NewsArticle::where('userId', $userId);

        // Apply the category filter if provided
        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }

        // Apply the time filter if provided
        if ($timeFilter) {
            // Customize this based on your desired time filter logic
            if ($timeFilter === 'today') {
                $query->whereDate('published_at', now()->toDateString());
            } elseif ($timeFilter === 'week') {
                $query->whereDate('published_at', '>=', now()->subWeek()->toDateString());
            } elseif ($timeFilter === 'month') {
                $query->whereDate('published_at', '>=', now()->subMonth()->toDateString());
            }
        }

        // Fetch the filtered news articles with pagination
        $newsArticles = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

        // Return the paginated news articles as a JSON response
        return response()->json($newsArticles);
    }
}
