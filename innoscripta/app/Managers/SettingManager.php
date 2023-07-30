<?php
namespace App\Managers;

use App\Actions\Setting\GetSingleSettingAction;
use App\Entities\SettingEntity;
use App\Exceptions\SettingKeyNotFoundAnyWhereException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class SettingManager
 * @package App\Managers
 */
class SettingManager
{
    /**
     * @var array
     */
    private array $_persisted_keys = [];

    /**
     * @var GetSingleSettingAction
     */
    private GetSingleSettingAction $getSingleSettingAction;

    /**
     * SettingManager constructor.
     * @param GetSingleSettingAction $getSingleSettingAction
     */
    public function __construct(GetSingleSettingAction $getSingleSettingAction)
    {
        $this->getSingleSettingAction = $getSingleSettingAction;
    }

    /**
     * @param string $key
     * @return string
     * @throws SettingKeyNotFoundAnyWhereException
     */
    public function get(string $key): string
    {
        if(array_key_exists($key, $this->_persisted_keys)) {
            $setting = $this->_persisted_keys[$key];
        }
        else {
            try {
                $setting = $this->getSingleSettingAction->getByKey($key);
            }
            catch (ModelNotFoundException $e) {
                if(env($key) !==null) {
                    $setting = (new SettingEntity())->setKey($key)->setValue(env($key));
                }
                else {
                    throw new SettingKeyNotFoundAnyWhereException($key);
                }
            }
        }

        $this->_persisted_keys[$key] = $setting;
        return $setting->getValue();
    }
}
