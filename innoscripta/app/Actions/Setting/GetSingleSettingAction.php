<?php
namespace App\Actions\Setting;

use App\Entities\SettingEntity;
use App\Repos\SettingRepository;

/**
 * Class GetSingleSettingAction
 * @package App\Actions\Setting
 */
class GetSingleSettingAction
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
     * @param int $id
     * @return SettingEntity
     */
    public function __invoke(int $id)
    {
        return $this->settingRepository->findOneById($id);
    }

    /**
     * @param string $key
     * @return SettingEntity
     */
    public function getByKey(string $key)
    {
        return $this->settingRepository->getSettingByKey($key);
    }

    /**
     * @param int $id
     * @return SettingEntity
     */
    public function getById(int $id)
    {
        return $this->__invoke($id);
    }

}
