<?php
namespace App\Actions\Setting;

use App\Entities\SettingEntity;
use App\Repos\SettingRepository;

/**
 * Class DeleteSettingAction
 * @package App\Actions\Setting
 */
class DeleteSettingAction
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
     * @param SettingEntity|int $setting
     * @return int
     */
    public function __invoke($setting)
    {
        return $this->settingRepository->delete($setting);
    }

}
