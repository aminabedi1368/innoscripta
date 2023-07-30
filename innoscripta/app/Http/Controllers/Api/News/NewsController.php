<?php

namespace App\Http\Controllers\Api\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BBCNewsService;
use App\Services\NewYorkTimesService;
use App\Services\TheGuardianNewsService;
use App\Models\NewsArticle;
use App\Lib\TokenInfoVO;

class NewsController extends Controller
{
    protected $bbcNewsService;

    public function __construct(
        BBCNewsService $bbcNewsService,
        NewYorkTimesService $NewYorkTimesService,
        TheGuardianNewsService $TheGuardianNewsService,
    )
    {
        $this->bbcNewsService = $bbcNewsService;
        $this->NewYorkTimesService = $NewYorkTimesService;
        $this->TheGuardianNewsService = $TheGuardianNewsService;
    }

//    public function fetchAndStoreNews(Request $request)
//    {
//        $category = $request->query('category', 'general'); // Default to 'general' if 'category' is not provided in the query params
//        $pageSize = $request->query('pageSize', 100); // Default to 100 if 'pageSize' is not provided in the query params
//
//        /** @var TokenInfoVO $tokenInfo */
//        $tokenInfo = $request->get('tokenInfo');
//        dd($tokenInfo);
//
//        $tokenInfo->getUserEntity();
//
//
//        $resultNewYorkTimesService = $this->NewYorkTimesService->fetchNewsArticles($category,$pageSize);
//        $resultTheGuardianNewsService = $this->TheGuardianNewsService->fetchNewsArticles($category,$pageSize);
//        $resultbbcNewsService = $this->bbcNewsService->fetchNewsArticles($category,$pageSize);
//
//        if ($resultbbcNewsService) {
//            return response()->json(['message' => 'News articles have been fetched and stored']);
//        } else {
//            return response()->json(['message' => 'failed to import'], 500);
//        }
//    }

    public function __invoke()
    {
        $category = request()->query('category', 'general');
        $pageSize = request()->query('Size', 10);
        $pageNumber = request()->query('page', 1);

        // Get news articles from the database with pagination
        $newsArticles = NewsArticle::where('category', $category)
            ->paginate($pageSize, ['*'], 'page', $pageNumber);

        return response()->json($newsArticles);
    }
}
