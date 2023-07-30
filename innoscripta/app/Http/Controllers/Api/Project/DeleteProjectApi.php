<?php
namespace App\Http\Controllers\Api\Project;

use App\Actions\Project\DeleteProjectAction;
use Illuminate\Http\Response;

/**
 * Class DeleteProjectApi
 * @package App\Http\Controllers\Api\Project
 */
class DeleteProjectApi
{

    /**
     * @var DeleteProjectAction
     */
    private DeleteProjectAction $deleteProjectAction;

    /**
     * DeleteProjectApi constructor.
     * @param DeleteProjectAction $deleteProjectAction
     */
    public function __construct(DeleteProjectAction $deleteProjectAction)
    {
        $this->deleteProjectAction = $deleteProjectAction;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id)
    {
        $this->deleteProjectAction->__invoke($id);

        return response()->noContent();
    }

}
