<?php
namespace App\Actions\Client;

use App\Entities\ProjectEntity;
use App\Repos\ClientRepository;

/**
 * Class ListClientByProjectAction
 * @package App\Actions\Client
 */
class ListClientByProjectAction
{
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;


    /**
     * ListClientByProjectAction constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param string $slug
     * @return ProjectEntity
     */
    public function __invoke(string $slug)
    {
        return $this->clientRepository->listClientsByProjectSlug($slug);
    }

}
