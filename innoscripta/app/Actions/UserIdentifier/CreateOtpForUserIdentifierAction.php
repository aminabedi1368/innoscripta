<?php
namespace App\Actions\UserIdentifier;

use App\Constants\SettingConstants;
use App\Entities\OtpEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use App\Managers\SettingManager;
use App\Repos\OtpRepository;
use Carbon\Carbon;

/**
 * Class CreateOtpForUserIdentifierAction
 * @package App\Actions\UserIdentifier
 */
class CreateOtpForUserIdentifierAction
{
    /**
     * @var OtpRepository
     */
    private OtpRepository $otpRepository;

    /**
     * @var SettingManager
     */
    private SettingManager $settingManager;


    /**
     * CreateOtpForUserIdentifierAction constructor.
     * @param OtpRepository $otpRepository
     * @param SettingManager $settingManager
     */
    public function __construct(OtpRepository $otpRepository, SettingManager $settingManager)
    {
        $this->otpRepository = $otpRepository;
        $this->settingManager = $settingManager;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return OtpEntity
     * @throws SettingKeyNotFoundAnyWhereException
     */
    public function __invoke(UserIdentifierEntity $userIdentifierEntity)
    {
        $expiresAt = Carbon::now()->addMinutes($this->settingManager->get(SettingConstants::OTP_EXPIRE_IN_MINUTES));

        $otpEntity = (new OtpEntity())
            ->setUserId($userIdentifierEntity->getUserId())
            ->setUserIdentifierId($userIdentifierEntity->getId())
            ->setExpiresAt($expiresAt)
            ->setUsedAt(null)
            ->setCode($this->otpRepository->getNewCode());

        return $this->otpRepository->insertOtp($otpEntity);
    }

}
