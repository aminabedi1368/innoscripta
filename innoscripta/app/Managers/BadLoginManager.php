<?php
namespace App\Managers;

use App\Entities\BadLoginEntity;
use App\Models\BadLoginModel;

/**
 * Class BadLoginManager
 * @package App\Managers
 */
class BadLoginManager
{
    /**
     * @var BadLoginModel
     */
    private BadLoginModel $badLoginModel;

    /**
     * BadLoginManager constructor.
     * @param BadLoginModel $badLoginModel
     */
    public function __construct(BadLoginModel $badLoginModel)
    {
        $this->badLoginModel = $badLoginModel;
    }

    /**
     * @param BadLoginEntity $badLoginEntity
     */
    public function logBadLogin(BadLoginEntity $badLoginEntity)
    {
        $this->badLoginModel->newQuery()->create([
            'username' => $badLoginEntity->getUsername(),
            'user_identifier_id' => $badLoginEntity->getUserIdentifierId(),
            'password' => $badLoginEntity->getPassword(),
            'login_type' => $badLoginEntity->getLoginType(),
            'device_os' => $badLoginEntity->getOsType() ?? "Unknown",
            'device_type' => $badLoginEntity->getDeviceType(),
            'ip' => $badLoginEntity->getIp(),

        ]);
    }

}
