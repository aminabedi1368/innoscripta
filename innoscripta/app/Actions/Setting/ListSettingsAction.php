<?php
namespace App\Actions\Setting;

use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\SettingRepository;

/**
 * Class ListSettingsAction
 * @package App\Actions\Setting
 */
class ListSettingsAction
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
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function __invoke(ListCriteria $listCriteria)
    {
        return $this->settingRepository->listSettings($listCriteria);
    }

}
