<?php

namespace App\Actions\News;

use App\Entities\UserEntity;
use App\Repos\UserRepository;
use App\Services\BBCNewsService;
use App\Services\NewYorkTimesService;
use App\Services\TheGuardianNewsService;
use App\Entities\NewsArticleEntity;

/**
 * Class UploadUserAvatarAction
 * @package App\Actions\User
 */
class FetchAndStoreNewsAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UploadUserAvatarAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository         $userRepository,
                                BBCNewsService         $bbcNewsService,
                                NewYorkTimesService    $NewYorkTimesService,
                                TheGuardianNewsService $TheGuardianNewsService
    )
    {
        $this->userRepository = $userRepository;
        $this->bbcNewsService = $bbcNewsService;
        $this->NewYorkTimesService = $NewYorkTimesService;
        $this->TheGuardianNewsService = $TheGuardianNewsService;
    }


    public function __invoke(UserEntity $userEntity, string $category, int $pageSize)
    {

        $resultNewYorkTimesService = $this->NewYorkTimesService->fetchNewsArticles($userEntity->getId(), $category, $pageSize);
        $resultTheGuardianNewsService = $this->TheGuardianNewsService->fetchNewsArticles($userEntity->getId(), $category, $pageSize);
        $resultbbcNewsService = $this->bbcNewsService->fetchNewsArticles($userEntity->getId(), $category, $pageSize,);
        // Merge the results into a single array
        $mergedResult = array_merge($resultNewYorkTimesService, $resultTheGuardianNewsService, $resultbbcNewsService);

        // Reindex the numeric keys in the merged array
        $reindexedResult = array_values($mergedResult);

        // Convert the reindexed array into a collection (optional)
        $mergedCollection = collect($reindexedResult);

        // Return the merged collection or the reindexed array (choose one based on your preference)
        return $mergedCollection;

    }

}
