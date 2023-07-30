<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\CreateClientAction;
use App\Hydrators\ClientHydrator;
use App\Validators\ClientValidator;
use Illuminate\Http\JsonResponse;

/**
 * Class CreateClientApi
 * @package App\Http\Controllers\Api\Client
 */
class CreateClientApi
{
    /**
     * @var CreateClientAction
     */
    private CreateClientAction $createClientAction;

    /**
     * @param ClientValidator $clientValidator
     */
    private ClientValidator $clientValidator;

    /**
     * @param ClientHydrator $clientHydrator
     */
    private ClientHydrator $clientHydrator;

    /**
     * CreateClientApi constructor.
     *
     * @param CreateClientAction $createClientAction
     * @param ClientValidator $clientValidator
     * @param ClientHydrator $clientHydrator
     *
     * @param CreateClientAction $createClientAction
     */
    public function __construct(
        CreateClientAction $createClientAction,
        ClientValidator $clientValidator,
        ClientHydrator $clientHydrator
    )
    {
        $this->createClientAction = $createClientAction;
        $this->clientValidator = $clientValidator;
        $this->clientHydrator = $clientHydrator;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        $requestArray = request()->except('tokenInfo');

        $this->clientValidator->validateCreateClient($requestArray);

        $clientEntity = $this->clientHydrator->fromArray($requestArray)->toEntity();

        $persistedClientEntity = $this->createClientAction->__invoke($clientEntity);

        return response()->json($this->clientHydrator->fromEntity($persistedClientEntity)->toArray());
    }

}
