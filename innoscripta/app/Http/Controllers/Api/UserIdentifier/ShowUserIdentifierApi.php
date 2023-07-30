<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Hydrators\UserIdentifierHydrator;
use App\Repos\UserIdentifierRepository;
use Illuminate\Http\JsonResponse;

/**
 * ShowUserIdentifierApi
 */
class ShowUserIdentifierApi
{

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * @var UserIdentifierHydrator
     */
    private UserIdentifierHydrator $userIdentifierHydrator;

    /**
     * @param UserIdentifierRepository $userIdentifierRepository
     * @param UserIdentifierHydrator $userIdentifierHydrator
    */
    public function __construct(
        UserIdentifierRepository $userIdentifierRepository,
        UserIdentifierHydrator $userIdentifierHydrator
    ) {
        $this->userIdentifierHydrator = $userIdentifierHydrator;
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $userIdentifierEntity = $this->userIdentifierRepository->findById($id);

        return response()->json($this->userIdentifierHydrator->fromEntity($userIdentifierEntity)->toArray());
    }

}
