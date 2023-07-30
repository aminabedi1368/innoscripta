<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\UpdateClientAction;
use App\Hydrators\ClientHydrator;
use App\Validators\ClientValidator;

/**
 * Class UpdateClientApi
 * @package App\Http\Controllers\Api\Client
 */
class UpdateClientApi
{
    /**
     * @var UpdateClientAction
     */
    private UpdateClientAction $updateClientAction;

    /**
     * @var ClientHydrator
     */
    private ClientHydrator $clientHydrator;

    /**
     * @var ClientValidator
     */
    private ClientValidator $clientValidator;


    /**
     * @param UpdateClientAction $updateClientAction
     * @param ClientHydrator $clientHydrator
     */
    public function __construct(
        UpdateClientAction $updateClientAction,
        ClientHydrator $clientHydrator,
        ClientValidator $clientValidator
    )
    {
        $this->updateClientAction = $updateClientAction;
        $this->clientHydrator = $clientHydrator;
        $this->clientValidator = $clientValidator;
    }

    public function __invoke()
    {
        $requestArray = request()->except('tokenInfo');

        $this->clientValidator->validateUpdateClient($requestArray);

        $clientEntity = $this->clientHydrator->fromArray($requestArray)->toEntity();

        $updatedClientEntity = $this->updateClientAction->__invoke($clientEntity);

        return response()->json($this->clientHydrator->fromEntity($updatedClientEntity)->toArray());
    }

}
