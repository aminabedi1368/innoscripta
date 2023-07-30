<?php
namespace App\Http\Controllers\Api\Project;

use App\Actions\Project\CreateProjectAction;
use App\Entities\ProjectEntity;
use App\Entities\UserEntity;
use App\Hydrators\ProjectHydrator;
use App\Repos\UserRepository;
use App\Validators\ProjectValidator;
use Illuminate\Validation\ValidationException;

/**
 * Class CreateProjectApi
 * @package App\Http\Controllers\Api\Project
 */
class CreateProjectApi
{
    /**
     * @var CreateProjectAction
     */
    private CreateProjectAction $createProjectAction;

    /**
     * @var ProjectValidator
     */
    private ProjectValidator $projectValidator;

    /**
     * @var ProjectHydrator
     */
    private ProjectHydrator $projectHydrator;


    /**
     * CreateProjectApi constructor.
     * @param CreateProjectAction $createProjectAction
     * @param ProjectValidator $projectValidator
     * @param ProjectHydrator $projectHydrator
     */
    public function __construct(
        CreateProjectAction $createProjectAction,
        ProjectValidator $projectValidator,
        ProjectHydrator $projectHydrator
    )
    {
        $this->createProjectAction = $createProjectAction;
        $this->projectValidator = $projectValidator;
        $this->projectHydrator = $projectHydrator;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke()
    {
        $this->projectValidator->validateCreateProject($data = request()->only('name', 'slug', 'description'));

        $persistedProjectEntity = $this->createProjectAction->__invoke(
            $this->buildProjectEntity($data)
        );

        return response()->json($this->projectHydrator->fromEntity($persistedProjectEntity)->toArray());
    }

    /**
     * todo : get logged in user from request
     *
     * @return UserEntity
     */
    private function getLoggedInUserEntity()
    {
        /** @var UserRepository $userRepository */
        $userRepository = resolve(UserRepository::class);

        return $userRepository->findOneById(1);
    }

    /**
     * @param array $data
     * @return ProjectEntity
     */
    private function buildProjectEntity(array $data)
    {
        $data = array_merge($data, ['creator_user_id'=> $this->getLoggedInUserEntity()->getId()]);

        return $this->projectHydrator->fromArray($data)->toEntity();
    }

}
