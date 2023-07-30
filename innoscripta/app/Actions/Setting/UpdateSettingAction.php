<?php
namespace App\Actions\Setting;

use App\Entities\SettingEntity;
use App\Repos\SettingRepository;

/**
 * Class UpdateSettingAction
 * @package App\Actions\Setting
 */
class UpdateSettingAction
{
    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;

    /**
     * CreateSettingAction constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param SettingEntity $settingEntity
     * @return SettingEntity
     */
    public function __invoke(SettingEntity $settingEntity)
    {
        return $this->settingRepository->updateSetting($settingEntity);
    }

}
