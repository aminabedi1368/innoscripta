<?php
namespace App\Repos;

use App\Entities\SettingEntity;
use App\Hydrators\SettingHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\SettingModel;

/**
 * Class SettingRepository
 * @package App\Repos
 */
class SettingRepository
{

    use RepoTrait;

    /**
     * @var SettingModel
     */
    private SettingModel $settingModel;

    /**
     * @var SettingHydrator
     */
    private SettingHydrator $settingHydrator;

    /**
     * SettingRepository constructor.
     * @param SettingModel $settingModel
     * @param SettingHydrator $settingHydrator
     */
    public function __construct(SettingModel $settingModel, SettingHydrator $settingHydrator)
    {
        $this->settingModel = $settingModel;
        $this->settingHydrator = $settingHydrator;
    }

    /**
     * @param string $key
     * @return SettingEntity
     */
    public function getSettingByKey(string $key)
    {
        /** @var SettingModel $settingModel */
        $settingModel = $this->settingModel->newQuery()->where('key', $key)->firstOrFail();

        return $this->settingHydrator->fromModel($settingModel)->toEntity();
    }

    /**
     * @param array $keys
     * @return SettingEntity[]
     */
    public function getMultipleSettingsByTheirKeys(array $keys)
    {
        /** @var SettingModel[] $listSettingModels */
        $listSettingModels = $this->settingModel->newQuery()->whereIn('key', $keys)->get();

        return $this->settingHydrator->fromArrayOfModels($listSettingModels)->toArrayOfEntities();
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function listSettings(ListCriteria $listCriteria)
    {
        $paginatedSettings = $this->makePaginatedList($listCriteria, $this->settingModel);

        $entities = [];

        foreach ($paginatedSettings->getItems() as $item) {
            $entities[] = $this->settingHydrator->fromArray($item)->toEntity();
        }
        $paginatedSettings->setItems($entities);

        $settingHydrator = $this->settingHydrator;

        $paginatedSettings->setItemsToArrayFunction(function(array $items) use ($settingHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $settingHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedSettings;
    }


    /**
     * @param SettingEntity $settingEntity
     * @return SettingEntity
     */
    public function insert(SettingEntity $settingEntity)
    {
        /** @var SettingModel $settingModel */
        $settingModel = $this->settingModel->newQuery()->create(
            $this->settingHydrator->fromEntity($settingEntity)->toArray()
        );

        return $settingEntity->setId($settingModel->id);
    }

    /**
     * @param int|SettingEntity $setting
     * @return int
     */
    public function delete($setting)
    {
        $setting_id = $setting;

        if($setting instanceof SettingEntity) {
            $setting_id = $setting->getId();
        }

        return $this->settingModel->newQuery()->where('id', $setting_id)->delete();
    }

    /**
     * @param string $key
     * @return int
     */
    public function deleteByKey(string $key)
    {
        return $this->settingModel->newQuery()->where('key', $key)->delete();
    }

    /**
     * @param int $id
     * @return SettingEntity
     */
    public function findOneById(int $id)
    {
        /** @var SettingModel $model */
        $model = $this->settingModel->newQuery()->firstOrFail($id);

        return $this->settingHydrator->fromModel($model)->toEntity();
    }

    /**
     * @param SettingEntity $settingEntity
     * @return SettingEntity
     */
    public function updateSetting(SettingEntity $settingEntity)
    {
        $this->settingModel->newQuery()->where('id', $settingEntity->getId())->update(
            $this->settingHydrator->fromEntity($settingEntity)->toArray()
        );

        return $settingEntity;
    }

}
