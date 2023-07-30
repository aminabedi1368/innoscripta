<?php
namespace App\Repos;

use App\Entities\ClientEntity;
use App\Entities\ProjectEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Hydrators\ClientHydrator;
use App\Hydrators\ProjectHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\ClientModel;
use App\Models\ProjectModel;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * Class ClientRepository
 * @package App\Repos
 */
class ClientRepository implements ClientRepositoryInterface
{

    use RepoTrait;

    /**
     * @var ClientModel
     */
    private ClientModel $clientModel;

    /**
     * @var ClientHydrator
     */
    private ClientHydrator $clientHydrator;

    /**
     * ClientRepository constructor.
     * @param ClientModel $clientModel
     * @param ClientHydrator $clientHydrator
     */
    public function __construct(ClientModel $clientModel, ClientHydrator $clientHydrator)
    {
        $this->clientModel = $clientModel;
        $this->clientHydrator = $clientHydrator;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function listClients(ListCriteria $listCriteria)
    {
        $paginatedClients =  $this->makePaginatedList($listCriteria, $this->clientModel);

        $entities = [];

        foreach ($paginatedClients->getItems() as $item) {
            $entities[] = $this->clientHydrator->fromArray($item)->toEntity();
        }
        $paginatedClients->setItems($entities);

        $clientHydrator = $this->clientHydrator;

        $paginatedClients->setItemsToArrayFunction(function(array $items) use ($clientHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $clientHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedClients;
    }


    /**
     * @param integer $projectId
     * @return ClientEntity[]
     */
    public function listClientsByProjectId(int $projectId)
    {
        $clients = $this->clientModel->newQuery()->where('project_id', $projectId)->get()->toArray();

        return $this->clientHydrator->fromArrayOfArrays($clients)->toArrayOfEntities();
    }

    /**
     * @param string $clientIdentifier
     * @return ClientEntity
     * @throws InvalidUserCredentialsException
     */
    public function getClientEntity($clientIdentifier)
    {
        /** @var ClientModel $clientModel */
        $clientModel = $this->clientModel->newQuery()->where('client_id', '=', $clientIdentifier)->first();

        if (is_null($clientModel)) {
            throw new InvalidUserCredentialsException;
//            throw new ClientNotFoundException('client not found with specified credentials');
        }

        return $this->clientHydrator->fromModel($clientModel)->toEntity();
    }

    /**
     * @param string $clientIdentifier
     * @param string|null $clientSecret
     * @param string|null $grantType
     * @return bool
     * @throws InvalidUserCredentialsException
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        /** @var ClientModel $clientModel */
        $clientModel = $this->clientModel->newQuery()
            ->where('client_id', '=', $clientIdentifier)
            ->first();

        if (is_null($clientModel)) {
            throw new InvalidUserCredentialsException;
//            throw new ClientNotFoundException('client not found with specified credentials');
        }

        if ($clientSecret !== $this->clientHydrator->fromModel($clientModel)->toEntity()->getClientSecret()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $slug
     * @return ProjectEntity
     */
    public function listClientsByProjectSlug(string $slug)
    {
        $projectModel = new ProjectModel();

        /** @var ProjectModel $project */
        $project = $projectModel->newQuery()->with('clients')->where('slug', $slug)->firstOrFail();

        /** @var ProjectHydrator $projectHydrator */
        $projectHydrator = resolve(ProjectHydrator::class);

        return $projectHydrator->fromModel($project)->toEntity();
    }


    /**
     * @param integer $id
     * @return ClientEntity
     */
    public function findClientById(int $id)
    {
        $clientModel = $this->clientModel->newQuery()->findOrFail($id);

        return $this->clientHydrator->fromModel($clientModel)->toEntity();
    }


    /**
     *
     * @param ClientEntity $clientEntity
     * @return void
     */
    public function insertClient(ClientEntity $clientEntity)
    {
        $clientModel = new ClientModel();
        $clientModel->name = $clientEntity->getName();
        $clientModel->slug = $clientEntity->getSlug();
        $clientModel->type = $clientEntity->getType();
        $clientModel->project_id = $clientEntity->getProjectId();
        $clientModel->redirect_urls = json_encode($clientEntity->getRedirectUri());
        $clientModel->client_id = $clientEntity->getClientId();
        $clientModel->is_active = $clientEntity->isActive();
        $clientModel->client_secret = $clientEntity->getClientSecret();

        $clientModel->save();

        return $clientEntity->setId($clientModel->id);
    }


    /**
     * @param ClientEntity $clientEntity
     * @return ClientEntity
     */
    public function updateClient(ClientEntity $clientEntity)
    {
        $clientArray = $this->clientHydrator->fromEntity($clientEntity)->toArray();

        $this->clientModel->newQuery()->where('id', $clientEntity->getId())
            ->update($clientArray);

        return $clientEntity;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function deleteById(int $id)
    {
        $this->clientModel->newQuery()->where('id', $id)->delete();
    }

}
