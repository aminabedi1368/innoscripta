<?php
namespace App\Managers;

use App\Models\ExternalServiceErrorModel;

/**
 * Class ExternalServiceErrorManager
 * @package App\Managers
 */
class ExternalServiceErrorManager
{
    /**
     * @var ExternalServiceErrorModel
     */
    private ExternalServiceErrorModel $externalServiceErrorModel;


    /**
     * ExternalServiceErrorManager constructor.
     * @param ExternalServiceErrorModel $externalServiceErrorModel
     */
    public function __construct(ExternalServiceErrorModel $externalServiceErrorModel)
    {
        $this->externalServiceErrorModel = $externalServiceErrorModel;
    }

    /**
     * @param string $service_name
     * @param string $action
     * @param string $error
     * @param string $exception_class
     * @return ExternalServiceErrorModel
     */
    public function logError(string $service_name, string $action, string $error, string $exception_class)
    {
        /** @var ExternalServiceErrorModel $log */
        $log = $this->externalServiceErrorModel->newQuery()->create([
            'action' => $action,
            'service_name' => $service_name,
            'error_message' => $error,
            'exception_class' => $exception_class
        ]);

        return $log;
    }


}
